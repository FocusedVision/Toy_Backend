<?php

namespace Database\Seeders;

use App\Models\BadWord;
use Illuminate\Database\Seeder;

class BadWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $words = file_get_contents(resource_path('txt/words-black-list.txt'));

        $words_array = explode(',', $words);

        $upserts = [];

        foreach ($words_array as $word) {
            $upserts[] = [
                'word' => trim($word),
            ];
        }

        BadWord::upsert($upserts, ['word']);
    }
}
