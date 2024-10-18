<?php

namespace Database\Factories;

use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $this->faker->addProvider(new Restaurant($this->faker));
        return [
            'kode' => $this->faker->unique()->bothify('MKN-###'),
            'nama' => $this->faker->foodName(), // Nama makanan acak
            'harga' => $this->faker->numberBetween(5000, 50000), // Harga acak
            'is_ready' => $this->faker->boolean(),
            'gambar' => $this->faker->imageUrl(640, 480, 'food', true), // Gambar acak bertema makanan
            'category_id' => mt_rand(1, 5), // Hubungkan dengan kategori
        ];
    }
}
