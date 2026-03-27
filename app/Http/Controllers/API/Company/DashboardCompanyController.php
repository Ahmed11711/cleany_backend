<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Models\booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardCompanyController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $companyId = $request->company_id;

        $stats = [
            'totalRevenue' => (float) booking::where('company_id', $companyId)
                ->where('status', 'confirmed')
                ->sum('total_price'),

            'totalBookings' => booking::where('company_id', $companyId)->count(),

            'activeServices' => Service::where('company_id', $companyId)
                ->count(),

            'pendingBookings' => booking::where('company_id', $companyId)
                ->where('status', 'pending')
                ->count(),
        ];

        $chartData = booking::where('company_id', $companyId)
            ->where('status', 'confirmed')
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%a") as name'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('name')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'chartData' => $chartData
            ]
        ]);
    }

    public function recentBookings(Request $request)
    {
        $limit = $request->query('limit', 5);

        $bookings = booking::where('company_id', $request->user()->company_id)
            ->with(['service:id,name', 'user:id,name as user_name']) // تأكد من العلاقات في الـ Model
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }
}
