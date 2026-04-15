<?php

namespace Database\Seeders;

use App\Models\Academic\Level;
use App\Models\Academic\Section;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            // Primary Section
            ['section_code' => 'PRIM', 'name' => 'Primary 1', 'code' => 'P1', 'sort_order' => 1],
            ['section_code' => 'PRIM', 'name' => 'Primary 2', 'code' => 'P2', 'sort_order' => 2],
            ['section_code' => 'PRIM', 'name' => 'Primary 3', 'code' => 'P3', 'sort_order' => 3],
            ['section_code' => 'PRIM', 'name' => 'Primary 4', 'code' => 'P4', 'sort_order' => 4],
            ['section_code' => 'PRIM', 'name' => 'Primary 5', 'code' => 'P5', 'sort_order' => 5],
            ['section_code' => 'PRIM', 'name' => 'Primary 6', 'code' => 'P6', 'sort_order' => 6],
            ['section_code' => 'PRIM', 'name' => 'Primary 7', 'code' => 'P7', 'sort_order' => 7],
            
            // Idaad Section
            ['section_code' => 'IDAD', 'name' => 'Idaad 1', 'code' => 'I1', 'sort_order' => 1],
            ['section_code' => 'IDAD', 'name' => 'Idaad 2', 'code' => 'I2', 'sort_order' => 2],
            ['section_code' => 'IDAD', 'name' => 'Idaad 3', 'code' => 'I3', 'sort_order' => 3],
            
            // Thanawi Section
            ['section_code' => 'THAN', 'name' => 'Thanawi 1', 'code' => 'T1', 'sort_order' => 1],
            ['section_code' => 'THAN', 'name' => 'Thanawi 2', 'code' => 'T2', 'sort_order' => 2],
            ['section_code' => 'THAN', 'name' => 'Thanawi 3', 'code' => 'T3', 'sort_order' => 3],
            ['section_code' => 'THAN', 'name' => 'Thanawi 4', 'code' => 'T4', 'sort_order' => 4],
        ];
        
        foreach ($levels as $levelData) {
            $section = Section::where('code', $levelData['section_code'])->first();
            
            if ($section) {
                Level::updateOrCreate(
                    ['code' => $levelData['code']],
                    [
                        'section_id' => $section->id,
                        'name' => $levelData['name'],
                        'sort_order' => $levelData['sort_order'],
                        'status' => 'active',
                    ]
                );
            }
        }
    }
}