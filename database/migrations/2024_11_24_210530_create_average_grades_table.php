<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('average_grades', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Foreign Key to students
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Foreign Key to subjects
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); // Foreign Key to teachers
            $table->decimal('average', 5, 2);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('average_grades');
    }
};
