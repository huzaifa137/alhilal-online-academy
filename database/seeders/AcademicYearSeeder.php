<?php

namespace Database\Seeders;

use App\Models\Academic\AcademicYear;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        // Determine current academic year based on month
        // Academic year typically starts in January/February
        $academicStartYear = $currentMonth >= 1 ? $currentYear : $currentYear - 1;
        
        $academicYears = [
            [
                'name' => ($academicStartYear - 1) . '-' . $academicStartYear,
                'start_date' => Carbon::create($academicStartYear - 1, 1, 15),
                'end_date' => Carbon::create($academicStartYear, 12, 15),
                'is_current' => false,
                'status' => 'completed',
            ],
            [
                'name' => $academicStartYear . '-' . ($academicStartYear + 1),
                'start_date' => Carbon::create($academicStartYear, 1, 15),
                'end_date' => Carbon::create($academicStartYear + 1, 12, 15),
                'is_current' => true,
                'status' => 'active',
            ],
            [
                'name' => ($academicStartYear + 1) . '-' . ($academicStartYear + 2),
                'start_date' => Carbon::create($academicStartYear + 1, 1, 15),
                'end_date' => Carbon::create($academicStartYear + 2, 12, 15),
                'is_current' => false,
                'status' => 'pending',
            ],
        ];
        
        foreach ($academicYears as $year) {
            AcademicYear::updateOrCreate(
                ['name' => $year['name']],
                $year
            );
        }
        
        $this->command->info('Academic Years seeded successfully!');
    }
}