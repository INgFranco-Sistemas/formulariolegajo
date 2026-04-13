<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_forms', function (Blueprint $table) {
            $table->id();

            $table->string('full_name', 255);
            $table->string('dni', 8)->unique();
            $table->string('ruc', 11)->nullable();

            $table->foreignId('sex_id')->constrained('sexes')->restrictOnDelete();
            $table->foreignId('marital_status_id')->constrained('marital_statuses')->restrictOnDelete();

            $table->date('birth_date');
            $table->string('birth_place', 255);

            $table->boolean('has_disability')->default(false);
            $table->string('conadis_rui', 50)->nullable();

            $table->string('address', 255);
            $table->string('reference', 255)->nullable();
            $table->string('district', 150);
            $table->string('province', 150);
            $table->string('department', 150);

            $table->string('cellphone', 20);
            $table->string('personal_email', 150);

            $table->string('emergency_contact_name', 255);
            $table->string('emergency_contact_phone', 20);

            $table->string('profession', 255);
            $table->string('current_position', 255);
            $table->string('current_dependency', 255);
            $table->string('contract_resolution_number', 100);
            $table->date('employment_start_date');

            $table->foreignId('labor_regime_id')->constrained('labor_regimes')->restrictOnDelete();
            $table->string('labor_condition', 150)->nullable();
            $table->foreignId('pension_regime_id')->constrained('pension_regimes')->restrictOnDelete();

            $table->string('airshsp_code', 50)->nullable();
            $table->string('institutional_email', 150)->nullable();

            $table->boolean('has_labor_link')->default(true);
            $table->date('labor_end_date')->nullable();

            $table->boolean('is_parent')->default(false);

            $table->string('status', 20)->default('submitted');
            $table->timestamp('submitted_at')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_forms');
    }
};
