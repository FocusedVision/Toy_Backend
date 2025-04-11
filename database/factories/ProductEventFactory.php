<?php

namespace Database\Factories;

use App\Enums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductEvent>
 */
class ProductEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeThisMonth();

        return [
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }

    public function opened()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Enums\ProductEvent::OPENED,
            ];
        });
    }

    public function modelLoaded()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Enums\ProductEvent::MODEL_LOADED,
            ];
        });
    }

    public function animationPlayed()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Enums\ProductEvent::ANIMATION_PLAYED,
            ];
        });
    }

    public function fullAnimationPlayed()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Enums\ProductEvent::FULL_ANIMATION_PLAYED,
            ];
        });
    }

    public function wishlistAdded()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Enums\ProductEvent::WISHLIST_ADDED,
            ];
        });
    }

    public function likeAdded()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Enums\ProductEvent::LIKE_ADDED,
            ];
        });
    }

    public function openTimeSeconds()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Enums\ProductEvent::OPEN_TIME_SECONDS,
                'seconds' => rand(1, 600),
            ];
        });
    }
}
