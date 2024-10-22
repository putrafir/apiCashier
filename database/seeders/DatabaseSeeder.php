<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Categories::insert([
            [
                'id' => 1,
                'nama' => 'Minuman',
            ],
            [
                'id' => 2,
                'nama' => 'Cemilan',
            ],
            [
                'id' => 5,
                'nama' => 'Makanan',
            ],
        ]);


        Products::insert([
            [
                'kode' => 'MKN-069',
                'nama' => 'Cheese Burger',
                'harga' => 43899,
                'is_ready' => 0,
                'gambar' => 'cheese-burger.jpg',
                'category_id' => 2,
            ],
            [
                'kode' => 'MKN-120',
                'nama' => 'Kentang Goreng',
                'harga' => 38259,
                'is_ready' => 0,
                'gambar' => 'kentang-goreng.jpg',
                'category_id' => 2,
            ],
            [
                'kode' => 'MKN-014',
                'nama' => 'Pangsit',
                'harga' => 16714,
                'is_ready' => 1,
                'gambar' => 'pangsit.jpg',
                'category_id' => 2,
            ],
            [
                'kode' => 'MKN-578',
                'nama' => 'Bakso',
                'harga' => 14597,
                'is_ready' => 0,
                'gambar' => 'bakso.jpg',
                'category_id' => 5,
            ],
            [
                'kode' => 'MKN-948',
                'nama' => 'Lontong Opor Ayam',
                'harga' => 23733,
                'is_ready' => 0,
                'gambar' => 'lontong-opor-ayam.jpg',
                'category_id' => 5,
            ],
            [
                'kode' => 'MKN-281',
                'nama' => 'Mie Ayam Bakso',
                'harga' => 12002,
                'is_ready' => 0,
                'gambar' => 'mie-ayam-bakso.jpg',
                'category_id' => 5,
            ],
            [
                'kode' => 'MKN-701',
                'nama' => 'Mie Goreng',
                'harga' => 45325,
                'is_ready' => 1,
                'gambar' => 'mie-goreng.jpg',
                'category_id' => 5,
            ],
        ]);


        // Categories::factory(5)->create();
        // Products::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
