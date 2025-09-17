<?php
// File: database/seeders/DepartmentSeeder.php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular system'],
            ['name' => 'Neurology', 'description' => 'Brain and nervous system'],
            ['name' => 'Orthopedics', 'description' => 'Bones, joints, and muscles'],
            ['name' => 'Pediatrics', 'description' => 'Children healthcare'],
            ['name' => 'Dermatology', 'description' => 'Skin, hair, and nails'],
            ['name' => 'General Medicine', 'description' => 'General healthcare and consultation'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}