<?php

namespace Database\Seeders;

use App\Models\JenisHarga;
use App\Models\Satuan;
use App\Models\Shift;
use App\Models\Supplier;
use App\Models\TipeBarang;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Satuan::create(['name' => 'Pcs']);
        Satuan::create(['name' => 'Botol']);
        Satuan::create(['name' => 'Tablet']);
        Satuan::create(['name' => 'Box']);
        Satuan::create(['name' => 'Dus']);
        Satuan::create(['name' => 'Sachet']);
        Satuan::create(['name' => 'Strip']);
        Satuan::create(['name' => 'Capsul']);
        Satuan::create(['name' => 'Tube']);

        TipeBarang::create(['name' => 'Obat']);
        TipeBarang::create(['name' => 'Alkes']);
        TipeBarang::create(['name' => 'Konsinyasi']);
        TipeBarang::create(['name' => 'Minuman']);

        JenisHarga::create(['name' => 'Otc', 'persentase' => 14]);
        JenisHarga::create(['name' => 'Ethical', 'persentase' => 20]);
        JenisHarga::create(['name' => 'Generik', 'persentase' => 17]);
        JenisHarga::create(['name' => 'Resep', 'persentase' => 25]);
        JenisHarga::create(['name' => 'Halodoc', 'persentase' => 20]);

        Shift::create(['name' => '1', 'start' => '07:00 AM', 'end' => '02:00 PM']);
        Shift::create(['name' => '2', 'start' => '02:00 PM', 'end' => '09:00 PM']);
        Shift::create(['name' => '3', 'start' => '09:00 PM', 'end' => '07:00 AM']);

        Supplier::create(['name' => 'PT. BIna San Prima', 'telepon' => '0212123120', 'alamat' => '-']);
        Supplier::create(['name' => 'PT. Enseval Putra', 'telepon' => '0212123120', 'alamat' => '-']);
        Supplier::create(['name' => 'Apotek Ananda Celancang', 'telepon' => '0212123120', 'alamat' => '-']);
    }
}
