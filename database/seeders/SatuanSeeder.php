<?php

namespace Database\Seeders;

use App\Models\AturanPakai;
use App\Models\Dokter;
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
        Satuan::create(['name' => 'Amplop']);
        Satuan::create(['name' => 'Ampul']);
        Satuan::create(['name' => 'Botol']);
        Satuan::create(['name' => 'Box']);
        Satuan::create(['name' => 'Bungkus']);
        Satuan::create(['name' => 'Capsul']);
        Satuan::create(['name' => 'Dus']);
        Satuan::create(['name' => 'Pack']);
        Satuan::create(['name' => 'Pcs']);
        Satuan::create(['name' => 'Pot']);
        Satuan::create(['name' => 'Sachet']);
        Satuan::create(['name' => 'Strip']);
        Satuan::create(['name' => 'Supp']);
        Satuan::create(['name' => 'Tablet']);
        Satuan::create(['name' => 'Tube']);

        TipeBarang::create(['name' => 'Obat']);
        TipeBarang::create(['name' => 'Alkes']);
        TipeBarang::create(['name' => 'Konsinyasi']);
        TipeBarang::create(['name' => 'Minuman']);
        TipeBarang::create(['name' => 'Pelayanan']);
        TipeBarang::create(['name' => 'Resep']);

        Dokter::create(['name' => 'Dr. Angga', 'telepon' => '0']);
        AturanPakai::create(['name' => '3 x Sehari']);

        JenisHarga::create(['name' => 'Ethical', 'persentase' => 20]);
        JenisHarga::create(['name' => 'Otc', 'persentase' => 14]);
        JenisHarga::create(['name' => 'Generik', 'persentase' => 17]);
        JenisHarga::create(['name' => 'Lain-Lain', 'persentase' => 20]);
        JenisHarga::create(['name' => 'Resep', 'persentase' => 25]);
        JenisHarga::create(['name' => 'Erlimpex', 'persentase' => 20]);
        JenisHarga::create(['name' => 'Nutracare', 'persentase' => 20]);
        JenisHarga::create(['name' => 'Halodoc', 'persentase' => 20]);

        Shift::create(['name' => '1', 'start' => '07:00 AM', 'end' => '02:00 PM']);
        Shift::create(['name' => '2', 'start' => '02:00 PM', 'end' => '09:00 PM']);
        Shift::create(['name' => '3', 'start' => '09:00 PM', 'end' => '07:00 AM']);

        Supplier::create(['name' => 'Apotek Ananda Siliwangi', 'telepon' => '0212123120', 'alamat' => '-']);
        Supplier::create(['name' => 'Apotek Ananda Mundu', 'telepon' => '0212123120', 'alamat' => '-']);
        Supplier::create(['name' => 'Apotek Ananda Celancang', 'telepon' => '0212123120', 'alamat' => '-']);
        Supplier::create(['name' => 'PT. BIna San Prima', 'telepon' => '0212123120', 'alamat' => '-']);
        Supplier::create(['name' => 'PT. Enseval Putra', 'telepon' => '0212123120', 'alamat' => '-']);
    }
}
