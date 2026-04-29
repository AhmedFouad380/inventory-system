<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'name' => 'Site ' . $this->faker->streetName(),
            'location' => $this->faker->address(),
            'is_active' => true,
            'created_by' => User::first()?->id ?? 1,
        ];
    }
}
