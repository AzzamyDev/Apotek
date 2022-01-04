<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'psa']);
        Role::create(['name' => 'karyawan']);
        Role::create(['name' => 'keuangan']);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'admin123'
        ]);
        $admin->assignRole('admin');
    }
}
