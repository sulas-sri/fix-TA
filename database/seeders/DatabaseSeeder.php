<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SchoolClassSeeder::class,
            // StudentSeeder::class,
            // CashTransactionSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);

        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'kepsek']);
        // Role::create(['name' => 'siswa']);
    }
}
