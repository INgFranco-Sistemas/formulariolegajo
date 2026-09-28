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
            $table->string('academic_education', 50)
                ->nullable()
                ->after('birth_place');
        });
    }

    public function down(): void
    {
        Schema::table('employee_forms', function (Blueprint $table) {
            $table->dropColumn('academic_education');
        });
    }
};
