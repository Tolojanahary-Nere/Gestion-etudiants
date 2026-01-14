<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have some subjects
        $subjects = [
            ['name' => 'Mathématiques', 'coefficient' => 4],
            ['name' => 'Physique-Chimie', 'coefficient' => 3],
            ['name' => 'Français', 'coefficient' => 3],
            ['name' => 'Anglais', 'coefficient' => 2],
            ['name' => 'Histoire-Géo', 'coefficient' => 2],
            ['name' => 'Informatique', 'coefficient' => 3],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['name' => $subject['name']], $subject);
        }

        // Get all subjects
        $allSubjects = Subject::all();

        // Seed random grades for existing students
        $students = Student::all();
        if ($students->count() < 5) {
            // Create dummy students if not enough exist
            // Assuming simplified creation without dedicated StudentFactory for now if it doesn't exist
            // But let's check if we can run without it or simple insert
             \App\Models\Student::create(['name' => 'Jean Dupont', 'email' => 'jean@example.com', 'phone' => '0123456789', 'address' => 'Paris']);
             \App\Models\Student::create(['name' => 'Alice Martin', 'email' => 'alice@example.com', 'phone' => '0987654321', 'address' => 'Lyon']);
             \App\Models\Student::create(['name' => 'Bob Smith', 'email' => 'bob@example.com', 'phone' => '1122334455', 'address' => 'London']);
             \App\Models\Student::create(['name' => 'Emma Watson', 'email' => 'emma@example.com', 'phone' => '5544332211', 'address' => 'London']);
             \App\Models\Student::create(['name' => 'Lucas Podolski', 'email' => 'lucas@example.com', 'phone' => '6677889900', 'address' => 'Berlin']);
             $students = Student::all();
        }

        foreach ($students as $student) {
            foreach ($allSubjects as $subject) {
                // checks if grade already exists
                if (!Grade::where('student_id', $student->id)->where('subject_id', $subject->id)->exists()) {
                     Grade::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'value' => rand(5, 20), // Random grade between 5 and 20
                    ]);
                }
            }
        }
    }
}
