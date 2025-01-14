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
        Schema::create('period_grades', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade'); // Foreign Key to grades
            $table->enum('period', ['1st', '2nd', '3rd', '4th']);
            $table->decimal('grade', 5, 2);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('period_grades');
    }
};
