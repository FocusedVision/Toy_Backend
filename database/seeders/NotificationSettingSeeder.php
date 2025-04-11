<?php

namespace Database\Seeders;

use App\Enums;
use App\Models;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'notification_type' => Enums\NotificationType::NEW_PRODUCT_LIVE,
                'is_enabled' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Models\NotificationSetting::create($setting);
        }
    }
}
