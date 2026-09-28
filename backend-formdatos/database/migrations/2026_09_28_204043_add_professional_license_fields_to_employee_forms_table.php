<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employee_forms', function (Blueprint $table) {
            $table->boolean('has_professional_license')
                ->nullable();

            $table->string('professional_license_number', 100)
                ->nullable();

            $table->date('professional_license_valid_until')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_forms', function (Blueprint $table) {
            $table->dropColumn([
                'has_professional_license',
                'professional_license_number',
                'professional_license_valid_until',
            ]);
        });
    }
};