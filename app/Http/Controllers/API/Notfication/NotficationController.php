<?php

namespace App\Http\Controllers\API\Notfication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotficationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications() // بفرض وجود علاقة في موديل User
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'status' => true,
            'data' => $notifications
        ], 200);
    }

    /**
     * تحديد تنبيه واحد كـ مقروء
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        $notification->update(['is_read' => true]);

        return response()->json([
            'status' => true,
            'message' => 'Notification marked as read'
        ], 200);
    }

    /**
     * تحديد كل التنبيهات كـ مقروءة
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'status' => true,
            'message' => 'All notifications marked as read'
        ], 200);
    }

    /**
     * حذف تنبيه معين
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json([
            'status' => true,
            'message' => 'Notification deleted successfully'
        ], 200);
    }
}
