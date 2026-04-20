<?php

namespace App\Http\Controllers\Company\Specialy;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtysController extends Controller
{
    public function index(Request $request)
    {
        // جلب الـ ID من الريكويست مباشرة
        $companyId = $request->company_id;

        $specialties = Specialty::where('company_id', $companyId)
            ->latest()
            ->get();

        return response()->json($specialties);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id', // التأكد من وجود الشركة
        ]);

        $companyId = $request->company_id;

        $specialty = Specialty::create([
            'name' => $request->name,
            'company_id' => $companyId,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($specialty, 201);
    }

    public function update(Request $request, $id)
    {
        $companyId = $request->company_id;

        // البحث عن التخصص بشرط تبعيته لنفس الشركة المرسلة
        $specialty = Specialty::where('company_id', $companyId)->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $specialty->update($request->only(['name', 'is_active']));

        return response()->json($specialty);
    }

    public function destroy(Request $request, $id)
    {
        $companyId = $request->company_id;

        $specialty = Specialty::where('company_id', $companyId)->findOrFail($id);
        $specialty->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
