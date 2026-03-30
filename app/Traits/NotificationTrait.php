<?php

namespace App\Traits;

use App\Models\Notifaction;
use App\Models\Notification as NotificationModel;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

trait NotificationTrait
{
    /**
     */
    public function sendAndStoreNotification($user, $title, $body, $data = [])
    {
        // أولاً: التخزين في قاعدة البيانات
        Notifaction::create([
            'user_id' => $user->id,
            'title'   => $title,
            'message'    => $body,
            'is_read' => false,
        ]);

        // ثانياً: الإرسال عبر Firebase إذا كان التوكن موجوداً
        if ($user->fcm_token) {
            try {
                $messaging = app('firebase.messaging');

                $notification = FirebaseNotification::create($title, $body);

                $message = CloudMessage::fromArray([
                    'token' => $user->fcm_token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'data' => $data,
                ]);
                $messaging->send($message);
            } catch (\Exception $e) {
                // تسجيل الخطأ في اللوج لعدم تعطيل العملية الأساسية
                Log::error("Firebase Error: " . $e->getMessage());
            }
        }

        return true;
    }
}
