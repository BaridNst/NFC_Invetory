<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // User
        \App\Models\User::create([
            'nama' => 'Peminjam User',
            'username' => 'user',
            'password' => \Illuminate\Support\Facades\Hash::make('user123'),
            'role' => 'user',
        ]);

        // Sample Items
        \App\Models\Barang::create([
            'nama_barang' => 'Laptop ASUS ROG',
            'nfc_uid' => '04:A1:B2:C3:D4:E5:F6',
            'status_barang' => 'tersedia',
        ]);

        \App\Models\Barang::create([
            'nama_barang' => 'Proyektor Epson',
            'nfc_uid' => '04:F6:E5:D4:C3:B2:A1',
            'status_barang' => 'tersedia',
        ]);
    }
}
