<?php
// File: database/seeders/DatabaseSeeder.php (Update existing)

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
        ]);
    }
}