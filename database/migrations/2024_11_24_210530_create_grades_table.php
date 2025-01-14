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
        Schema::create('grades', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Foreign Key to students
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Foreign Key to subjects
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); // Foreign Key to teachers
            $table->decimal('first_period', 5, 2)->nullable();
            $table->decimal('second_period', 5, 2)->nullable();
            $table->decimal('third_period', 5, 2)->nullable();
            $table->decimal('fourth_period', 5, 2)->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
