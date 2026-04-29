<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Project ' . $this->faker->city(),
            'code' => strtoupper($this->faker->unique()->lexify('PRJ-????')),
            'description' => $this->faker->paragraph(),
            'is_active' => true,
            'created_by' => User::first()?->id ?? 1,
        ];
    }
}
