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
        Schema::create('sections', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('section_name');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); // Foreign Key to teachers
            $table->foreignId('grade_level_id')->nullable()->constrained('grade_levels'); // Foreign Key to grade_levels
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
