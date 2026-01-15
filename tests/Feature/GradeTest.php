<?php

use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it can add a grade to a student', function () {
    $student = Student::factory()->create();
    $subject = Subject::factory()->create();

    $response = $this->post(route('grades.store'), [
        'student_id' => $student->id,
        'subject_id' => $subject->id,
        'value' => 15,
    ]);

    $response->assertRedirect(route('grades.index'));
    $this->assertDatabaseHas('grades', [
        'student_id' => $student->id,
        'subject_id' => $subject->id,
        'value' => 15,
    ]);
});

test('it validates grade value range', function () {
    $student = Student::factory()->create();
    $subject = Subject::factory()->create();

    $response = $this->post(route('grades.store'), [
        'student_id' => $student->id,
        'subject_id' => $subject->id,
        'value' => 25, // Too high
    ]);

    $response->assertSessionHasErrors('value');
});

test('it can download a student report pdf', function () {
    $student = Student::factory()->create();
    $subject = Subject::factory()->create();
    Grade::create([
        'student_id' => $student->id,
        'subject_id' => $subject->id,
        'value' => 18,
    ]);

    $response = $this->get(route('students.report', $student));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
    $response->assertHeader('content-disposition', 'attachment; filename=bulletin_' . $student->id . '.pdf');
});
