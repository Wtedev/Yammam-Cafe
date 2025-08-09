<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suggestion>
 */
class SuggestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['suggestion', 'complaint', 'compliment'];
        $statuses = ['new', 'reviewing', 'approved', 'rejected', 'implemented'];

        return [
            'user_id' => $this->faker->optional(0.7)->randomElement(User::pluck('id')->toArray()),
            'name' => function (array $attributes) {
                return $attributes['anonymous'] ? 'مجهول' : $this->faker->name();
            },
            'suggestion' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement($types),
            'status' => $this->faker->randomElement($statuses),
            'anonymous' => $this->faker->boolean(20), // 20% مجهول
            'admin_response' => function (array $attributes) {
                return in_array($attributes['status'], ['approved', 'rejected', 'implemented'])
                    ? $this->faker->paragraph()
                    : null;
            },
            'responded_at' => function (array $attributes) {
                return in_array($attributes['status'], ['approved', 'rejected', 'implemented'])
                    ? $this->faker->dateTimeBetween('-1 month', 'now')
                    : null;
            },
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }

    public function anonymous()
    {
        return $this->state(fn(array $attributes) => [
            'anonymous' => true,
        ]);
    }

    public function registered()
    {
        return $this->state(fn(array $attributes) => [
            'anonymous' => false,
        ]);
    }
}
