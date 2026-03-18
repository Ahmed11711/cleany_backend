<?php

namespace App\Http\Controllers\BaseController;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

abstract class BaseController extends Controller
{
  use ApiResponseTrait;

  protected $repository;
  protected string $storeRequestClass;
  protected string $updateRequestClass;
  protected string $resourceClass;
  protected ?string $collectionName = null;
  protected array $fileFields = [];
  protected string $uploadDisk = 'public';
  protected array $withRelationships = [];
  protected bool $useCache = false;

  public function __construct() {}

  protected function initService($repository, string $collectionName, array $fileFields = [], string $uploadDisk = 'public'): void
  {
    $this->repository = $repository;
    $this->collectionName = $collectionName;
    $this->fileFields = $fileFields;
    $this->uploadDisk = $uploadDisk;
  }

  public function index(Request $request): JsonResponse
  {
    try {
      if ($this->useCache) {
        $tableName = $this->repository->query()->getModel()->getTable();
        $cacheKey = $tableName . '_list_' . md5(json_encode($request->all()));

        $data = Cache::remember($cacheKey, 3600, function () use ($request) {
          return $this->fetchData($request);
        });
      } else {
        $data = $this->fetchData($request);
      }

      return $this->successResponsePaginate($data, "{$this->collectionName} list retrieved successfully");
    } catch (\Throwable $e) {
      Log::error("Error in {$this->collectionName} index: " . $e->getMessage());
      return $this->errorResponse("Failed to fetch data", 500, $e->getMessage());
    }
  }

  public function show(int $id): JsonResponse
  {
    try {
      if ($this->useCache) {
        $tableName = $this->repository->query()->getModel()->getTable();
        $cacheKey = $tableName . '_show_' . $id;

        $record = Cache::remember($cacheKey, 3600, function () use ($id) {
          return $this->repository->query()->with($this->withRelationships)->find($id);
        });
      } else {
        $record = $this->repository->query()->with($this->withRelationships)->find($id);
      }

      if (!$record) return $this->errorResponse("Record not found", 404);

      return $this->successResponse(new $this->resourceClass($record), 'Record retrieved successfully');
    } catch (\Throwable $e) {
      Log::error("Error in {$this->collectionName} show: " . $e->getMessage());
      return $this->errorResponse("Failed to retrieve record", 500);
    }
  }

  protected function fetchData(Request $request)
  {
    $query = $this->repository->query()->with($this->withRelationships);

    if ($search = $request->input('search')) {
      $query->where(function ($q) use ($search) {
        $table = $q->getModel()->getTable();
        $stringColumns = array_filter(Schema::getColumnListing($table), fn($col) => !in_array($col, ['id', 'created_at', 'updated_at', 'deleted_at']));
        foreach ($stringColumns as $column) {
          $q->orWhere($column, 'like', "%{$search}%");
        }
      });
    }

    foreach ($request->except(['search', 'page', 'per_page']) as $key => $value) {
      if ($value !== null && $value !== '' && Schema::hasColumn($query->getModel()->getTable(), $key)) {
        $query->where($key, $value);
      }
    }

    $perPage = $request->input('per_page', 10);
    $data = $query->latest()->paginate($perPage);

    return class_exists($this->resourceClass) ? $this->resourceClass::collection($data) : $data;
  }

  public function store(Request $request): JsonResponse
  {
    $validated = app($this->storeRequestClass)->validated();
    try {
      DB::beginTransaction();
      $validated = $this->handleFileUploads($request, $validated);
      $record = $this->repository->create($validated);
      DB::commit();
      return $this->successResponse(new $this->resourceClass($record), 'Record created successfully', 201);
    } catch (\Throwable $e) {
      DB::rollBack();
      Log::error("Error creating {$this->collectionName}: " . $e->getMessage());
      return $this->errorResponse("Failed to create record", 500);
    }
  }

  public function update(Request $request, int $id): JsonResponse
  {
    $validated = app($this->updateRequestClass)->validated();
    $record = $this->repository->find($id);
    if (!$record) return $this->errorResponse("Record not found", 404);

    try {
      DB::beginTransaction();
      $validated = $this->handleFileUploads($request, $validated, $record);
      $record = $this->repository->update($id, $validated);
      DB::commit();
      return $this->successResponse(new $this->resourceClass($record), 'Record updated successfully');
    } catch (\Throwable $e) {
      DB::rollBack();
      Log::error("Error updating {$this->collectionName}: " . $e->getMessage());
      return $this->errorResponse("Failed to update record", 500);
    }
  }

  public function destroy($id): JsonResponse
  {
    try {
      DB::beginTransaction();
      $this->repository->delete($id);
      DB::commit();
      return $this->successResponse(null, "Record(s) deleted successfully");
    } catch (\Throwable $e) {
      DB::rollBack();
      Log::error("Error deleting {$this->collectionName}: " . $e->getMessage());
      return $this->errorResponse("Failed to delete record", 500);
    }
  }

  protected function handleFileUploads(Request $request, array $validated, $existingRecord = null): array
  {
    if (empty($this->fileFields)) return $validated;
    foreach ($this->fileFields as $field) {
      if ($request->hasFile($field)) {
        $file = $request->file($field);
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("uploads/{$this->collectionName}", $filename, $this->uploadDisk);
        if ($existingRecord && !empty($existingRecord->$field)) {
          Storage::disk($this->uploadDisk)->delete('uploads/' . $this->collectionName . '/' . basename($existingRecord->$field));
        }
        $validated[$field] = config('app.url') . "/storage/" . $path;
      }
    }
    return $validated;
  }
}
