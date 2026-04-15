<?php

namespace Database\Seeders;

use App\Models\Academic\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'name' => 'Primary',
                'code' => 'PRIM',
                'description' => 'Primary Section (P.1 - P.7)',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Idaad',
                'code' => 'IDAD',
                'description' => 'Idaad Section (S.1 - S.4)',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Thanawi',
                'code' => 'THAN',
                'description' => 'Thanawi Section (S.5 - S.6)',
                'sort_order' => 3,
                'status' => 'active',
            ],
        ];
        
        foreach ($sections as $section) {
            Section::updateOrCreate(['code' => $section['code']], $section);
        }
    }
}