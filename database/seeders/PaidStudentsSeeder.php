<?php

namespace Database\Seeders;

use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Lesson;
use App\Models\Academic\LessonPayment;
use App\Models\Academic\MaterialPayment;
use App\Models\Academic\SubjectMaterial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Two TEST students that are already "paid up", so lessons, classes, quizzes,
 * the report card and certificates can be tried out without paying.
 *
 *   php artisan db:seed --class=PaidStudentsSeeder
 *
 * For each test student it:
 *   - creates the account (or refreshes the password if it already exists);
 *   - enrols them in every active class that has published lessons, with the class fee marked as paid;
 *   - marks every priced lesson and study-material PDF in those classes as paid.
 *
 * It is safe to run again at any time: nothing is duplicated, and running it
 * after you add new classes / lessons / PDFs unlocks those for the test students too.
 */
class PaidStudentsSeeder extends Seeder
{
    public const PASSWORD = 'Student@123';

    private const STUDENTS = [
        [
            'reg_number' => 'STU-TEST-0001',
            'username' => 'paidstudent1',
            'email' => 'paidstudent1@mailinator.com',
            'firstname' => 'Aisha',
            'lastname' => 'Paid-Test',
            'gender' => 'female',
            'phonenumber' => '0700000001',
        ],
        [
            'reg_number' => 'STU-TEST-0002',
            'username' => 'paidstudent2',
            'email' => 'paidstudent2@mailinator.com',
            'firstname' => 'Yusuf',
            'lastname' => 'Paid-Test',
            'gender' => 'male',
            'phonenumber' => '0700000002',
        ],
    ];

    public function run(): void
    {
        // These accounts have a published password, so never create them on a
        // live site by accident.
        if (app()->environment('production')
            && !$this->command->confirm('This is a PRODUCTION environment. Create test students with a known password?', false)) {
            $this->command->warn('Cancelled. No test students were created.');
            return;
        }

        // Same rule as self-enrolment: only classes that already have a published lesson.
        $classes = ClassModel::where('status', 'active')
            ->whereHas('topics.lessons', fn($q) => $q->where('status', 'published'))
            ->get();
        $summary = [];

        foreach (self::STUDENTS as $student) {
            $studentId = $this->upsertStudent($student);
            $classCount = $lessonCount = $materialCount = 0;

            foreach ($classes as $class) {
                ClassEnrollment::updateOrCreate(
                    ['class_id' => $class->id, 'student_id' => $studentId],
                    [
                        'enrollment_date' => now()->toDateString(),
                        'status' => 'active',
                        'payment_status' => 'paid',
                        'amount_paid' => (int) config('marzpay.default_class_fee', 50000),
                    ]
                );
                $classCount++;

                $lessons = Lesson::whereHas('topic', fn($q) => $q->where('class_id', $class->id))->get();
                foreach ($lessons as $lesson) {
                    if ($lesson->isFree()) {
                        continue; // nothing to pay
                    }
                    LessonPayment::firstOrCreate(
                        ['lesson_id' => $lesson->id, 'student_id' => $studentId],
                        ['amount_paid' => (string) $lesson->lesson_amount, 'paid_at' => now()]
                    );
                    $lessonCount++;
                }

                $materials = SubjectMaterial::where('class_id', $class->id)->get();
                foreach ($materials as $material) {
                    if ($material->isFree()) {
                        continue;
                    }
                    MaterialPayment::firstOrCreate(
                        ['subject_material_id' => $material->id, 'student_id' => $studentId],
                        ['amount_paid' => (string) $material->amount, 'paid_at' => now()]
                    );
                    $materialCount++;
                }
            }

            $summary[] = [
                $student['email'],
                $student['username'],
                self::PASSWORD,
                "{$classCount} classes, {$lessonCount} paid lessons, {$materialCount} paid PDFs",
            ];
        }

        $this->command->info('Test students ready (already paid):');
        $this->command->table(['Email', 'Username', 'Password', 'Unlocked'], $summary);
    }

    private function upsertStudent(array $student): int
    {
        $now = now();
        $existing = DB::table('users')->where('email', $student['email'])->first();

        $fields = $student + [
            'password' => Hash::make(self::PASSWORD),
            'user_role' => 1,               // 1 = student
            'registration_status' => 1,     // verified
            'account_status' => 10,         // active
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('users')->where('id', $existing->id)->update($fields);
            return (int) $existing->id;
        }

        return (int) DB::table('users')->insertGetId($fields + ['created_at' => $now]);
    }
}
