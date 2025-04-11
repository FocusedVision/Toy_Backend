<?php

namespace Database\Seeders;

use App\Models\User; // Assuming you have a User model
use App\Models\NotificationSetting;
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
        // Fetch all users to create default notification settings for each user
        $users = User::all();

        foreach ($users as $user) {
            NotificationSetting::create([
                'user_id' => $user->id,
                'is_enabled' => true, // Default value
            ]);
        }
    }
}