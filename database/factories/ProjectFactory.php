<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProjectType;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'key' => fake()->unique()->regexify('[A-Z]{3}'),
            'type' => fake()->randomElement(ProjectType::cases()),
            'description' => fake()->sentence(),
        ];
    }
}
