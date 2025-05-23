<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\User;
use App\Models\Workflow;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workflow_id' => Workflow::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(Status::cases()),
            'data' => json_encode([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'phone' => fake()->phoneNumber(),
                'date' => Carbon::now()->format('Y-m-d'),
                'time' => Carbon::now()->format('H:i:s'),
                'address' => fake()->address(),
                'message' => fake()->text(),
            ]),
        ];
    }
}
