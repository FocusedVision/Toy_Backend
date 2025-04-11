<?php

namespace Database\Seeders;

use App\Models;
use Illuminate\Database\Seeder;

class ProductEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Models\Product::inRandomOrder()->get();
        $users = Models\User::inRandomOrder()->get();

        foreach ($products as $product) {
            $opened_count = 25;

            for ($i = 0; $i < $opened_count; $i++) {
                Models\ProductEvent::factory()->opened()->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
            }

            $model_loaded_count = 25;

            for ($i = 0; $i < $model_loaded_count; $i++) {
                Models\ProductEvent::factory()->modelLoaded()->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
            }

            $animation_played_count = 25;

            for ($i = 0; $i < $animation_played_count; $i++) {
                Models\ProductEvent::factory()->animationPlayed()->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
            }

            $full_animation_played_count = 25;

            for ($i = 0; $i < $full_animation_played_count; $i++) {
                Models\ProductEvent::factory()->fullAnimationPlayed()->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
            }

            $wishlist_added_count = 25;

            for ($i = 0; $i < $wishlist_added_count; $i++) {
                Models\ProductEvent::factory()->wishlistAdded()->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
            }

            $like_added_count = 25;

            for ($i = 0; $i < $like_added_count; $i++) {
                Models\ProductEvent::factory()->likeAdded()->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
            }

            $open_time_seconds_count = 25;

            for ($i = 0; $i < $open_time_seconds_count; $i++) {
                Models\ProductEvent::factory()->openTimeSeconds()->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}
