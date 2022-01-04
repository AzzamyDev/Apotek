<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jabatan::create(['nama' => 'Pemilik Sarana Apotek']);
        Jabatan::create(['nama' => 'Apoteker',]);
        Jabatan::create(['nama' => 'Asisten Apoteker',]);
        Jabatan::create(['nama' => 'Administrasi',]);
        Jabatan::create(['nama' => 'Keuangan',]);
    }
}
