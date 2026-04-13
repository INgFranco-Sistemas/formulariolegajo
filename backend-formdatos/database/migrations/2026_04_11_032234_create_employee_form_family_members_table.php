<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_form_family_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_form_id')
                ->constrained('employee_forms')
                ->cascadeOnDelete();

            $table->string('full_name', 255);
            $table->string('dni', 8)->nullable();
            $table->unsignedInteger('age');

            $table->foreignId('sex_id')->constrained('sexes')->restrictOnDelete();
            $table->foreignId('relationship_id')->constrained('family_relationships')->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_form_family_members');
    }
};
