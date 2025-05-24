<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Request;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Approval>
 */
class ApprovalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'request_id' => Request::inRandomOrder()->first()->id,
            'step_id' => Step::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(Status::cases()),
            'comment' => fake()->text(),
        ];
    }
}
