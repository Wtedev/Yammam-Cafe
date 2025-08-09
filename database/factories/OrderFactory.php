<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'processed', 'delivered', 'cancelled'];
        $paymentMethods = ['network', 'bank_transfer', 'cash'];
        $status = $this->faker->randomElement($statuses);

        return [
            'user_id' => User::factory(),
            'office_number' => $this->faker->optional(0.7)->numerify('##'),
            'status' => $status,
            'products' => json_encode([
                ['id' => 1, 'name' => 'قهوة عربية', 'quantity' => 2, 'price' => 15.00],
                ['id' => 2, 'name' => 'كابتشينو', 'quantity' => 1, 'price' => 18.00]
            ]),
            'total_price' => $this->faker->randomFloat(2, 10, 200),
            'order_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'delivery_time' => $this->faker->optional(0.5)->dateTimeBetween('now', '+2 hours'),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'payment_image_url' => $this->faker->optional(0.3)->imageUrl(400, 300, 'business'),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function pending()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function delivered()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'delivered',
        ]);
    }

    public function cancelled()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
