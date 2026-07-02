<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legajos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_form_id')
                ->constrained('employee_forms')
                ->cascadeOnDelete();

            $table->string('legajo_number', 50)->unique();

            $table->string('status', 20)->default('ACTIVO');

            $table->date('opening_date')->nullable();
            $table->date('closing_date')->nullable();

            $table->string('physical_location', 255)->nullable();
            $table->string('digital_location', 255)->nullable();

            $table->foreignId('dependency_id')
                ->nullable()
                ->constrained('dependencies')
                ->nullOnDelete();

            $table->foreignId('labor_regime_id')
                ->nullable()
                ->constrained('labor_regimes')
                ->nullOnDelete();

            $table->string('position_name', 255)->nullable();

            $table->integer('folios_total')->default(0);

            $table->text('observations')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legajos');
    }
};