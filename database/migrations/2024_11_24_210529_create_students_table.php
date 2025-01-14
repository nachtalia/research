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
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('lrn')->unique();
            $table->string('student_name');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null'); // Foreign Key to sections
            $table->foreignId('grade_level_id')->nullable()->constrained('grade_levels')->onDelete('set null'); // Foreign Key to grade_levels
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

