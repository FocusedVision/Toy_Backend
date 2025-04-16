<?php

namespace Database\Seeders;

use App\Enums\NotificationType;
use App\Models\User;
use App\Models\NotificationSetting;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    public function run()
    {
        $users = User::whereNotIn('id', function($query) {
            $query->select('user_id')
                  ->from('notification_settings');
        })->get();

        foreach ($users as $user) {
            NotificationSetting::create([
                'notification_type' => NotificationType::NEW_PRODUCT_LIVE,
                'user_id' => $user->id,
                'is_enabled' => true,
            ]);
        }
    }
}
