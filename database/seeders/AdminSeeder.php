<?php

namespace Database\Seeders;

use App\Models\Admin;
use Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inserts = [
            [
                'name' => 'Yarik',
                'email' => 'ym@empat.tech',
                'password' => Hash::make('secretpassword'),
            ],
        ];

        foreach ($inserts as $insert) {
            Admin::create($insert);
        }
    }
}
