<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $items = [
            'Copper Cable 4mm',
            'Steel Pipe 2 inch',
            'Safety Helmet White',
            'Screwdriver Set',
            'Welding Machine',
            'PVC Fitting 90 Degree',
            'LED Flood Light 50W',
            'Power Drill Bosch',
            'Work Gloves Leather',
            'Measuring Tape 5m',
        ];

        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'item_code' => strtoupper($this->faker->unique()->bothify('ITM-####??')),
            'name' => $this->faker->randomElement($items) . ' ' . $this->faker->word(),
            'description' => $this->faker->sentence(),
            'unit' => $this->faker->randomElement(['pcs', 'meter', 'kg', 'roll', 'box']),
            'is_active' => true,
            'created_by' => User::first()?->id ?? 1,
        ];
    }
}
