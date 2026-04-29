<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Electrical Materials',
            'Mechanical Parts',
            'Construction Tools',
            'Safety Equipment',
            'Pipes and Fittings',
            'Cables',
            'Chemicals',
            'Office Supplies',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'description' => $this->faker->sentence(),
            'is_active' => true,
            'created_by' => User::first()?->id ?? 1,
        ];
    }
}
