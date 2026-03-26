<?php

namespace App\Observers\User;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function saved(User $user)
    {
        $this->clearUserCache($user);
    }

    public function deleted(User $user)
    {
        $this->clearUserCache($user);
    }

    public function restored(User $user)
    {
        $this->clearUserCache($user);
    }

    protected function clearUserCache(User $user)
    {
        $tableName = $user->getTable();

        Cache::forget($tableName . '_show_' . $user->id);

        Cache::flush();
    }
}
