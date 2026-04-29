<?php

namespace Database\Factories;

use App\Models\Contractor;
use App\Models\Project;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkOrder>
 */
class WorkOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wo_number' => strtoupper($this->faker->unique()->bothify('WO-2024-####')),
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'site_id' => Site::inRandomOrder()->first()?->id ?? Site::factory(),
            'contractor_id' => Contractor::inRandomOrder()->first()?->id ?? Contractor::factory(),
            'contract_ref' => strtoupper($this->faker->bothify('CONT/####/2024')),
            'status' => $this->faker->randomElement(['open', 'closed', 'suspended']),
            'opened_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'notes' => $this->faker->paragraph(),
            'created_by' => User::first()?->id ?? 1,
        ];
    }
}
