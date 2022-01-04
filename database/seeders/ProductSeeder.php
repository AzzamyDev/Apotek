<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 100000; $i++) {

            Product::create([
                'name' => $faker->catchPhrase,
                'harga' => $faker->randomNumber(5),
                'golongan' => 'Bebas',
                'lokasi' => 'A1',
                'satuan' => 'PCS',
                'tipe_harga_id' => $faker->numberBetween(1, 3),
                'tipe_barang_id' => $faker->numberBetween(1, 3),
            ]);
        }
    }
}
