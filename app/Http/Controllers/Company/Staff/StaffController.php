<?php

namespace App\Http\Controllers\Company\Staff;

use App\Http\Controllers\Controller;
use App\Models\User; // افترضنا أن الموظف هو مستخدم في جدول users
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $companyId = $request->company_id;

        $staff = User::where('company_id', $companyId)
            ->where('role', 'staff')
            ->latest()
            ->get();
        return $this->successResponse($staff, "List OF Staff");
    }

    /**
     * تخزين موظف جديد وربطه بالشركة تلقائياً
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            // 'phone'     => 'required|string|max:20',
            'password'  => 'required|string|min:8',
        ]);

        $companyId = $request->company_id;

        $staff = User::create([
            'name'  => $request->name,
            'email'      => $request->email,
            // 'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'company_id' => $companyId, // الربط بالشركة هنا
            'role'       => 'staff',    // تمييزه كموظف
        ]);

        return $this->successResponse($staff, "Staff member created successfully");
    }


    public function update(Request $request, string $id)
    {
        $staff = User::where('company_id', $request->company_id)
            ->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email'     => 'sometimes|email|unique:users,email,' . $id,
            // 'phone'     => 'sometimes|string|max:20',
            'password'  => 'nullable|string|min:8',
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);
        return $this->successResponse($staff, "Staff updated successfully");
    }

    /**
     * حذف الموظف
     */
    public function destroy(Request $request, string $id)
    {
        $staff = User::where('company_id', $request->company_id)
            ->findOrFail($id);

        $staff->delete();


        return response()->json([
            'status' => 'success',
            'message' => 'Staff member deleted successfully'
        ]);
    }
}
