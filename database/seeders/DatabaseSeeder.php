<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Academic Structure Seeders
            SectionSeeder::class,
            LevelSeeder::class,
            AcademicYearSeeder::class,
            SubjectSeeder::class,
            
            // Role and Permission Seeders (if using Spatie)
            // RolePermissionSeeder::class,
            
            // Default Admin User
            // AdminUserSeeder::class,
        ]);
    }
}