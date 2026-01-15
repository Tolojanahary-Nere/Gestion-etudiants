<?php

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

uses(RefreshDatabase::class);

test('it can display the student list', function () {
    $response = $this->get('/students');

    $response->assertStatus(200);
});

test('it can create a student', function () {
    $studentData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '0123456789',
        'address' => '123 Main St',
    ];

    $response = $this->post('/students', $studentData);

    $response->assertRedirect(route('students.index'));
    $this->assertDatabaseHas('students', $studentData);
});

test('it requires email to be unique', function () {
    Student::factory()->create([
        'email' => 'duplicate@example.com',
    ]);

    $response = $this->post('/students', [
        'name' => 'Jane Doe',
        'email' => 'duplicate@example.com',
        'phone' => '0987654321',
        'address' => '456 Another St',
    ]);

    $response->assertSessionHasErrors('email');
});

test('it can download the students export', function () {
    Excel::fake();

    $this->get(route('students.export'));

    Excel::assertDownloaded('etudiants.xlsx', function(StudentsExport $export) {
        return true;
    });
});
