<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legajo_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('legajo_id')
                ->constrained('legajos')
                ->cascadeOnDelete();

            $table->foreignId('legajo_section_id')
                ->constrained('legajo_sections')
                ->restrictOnDelete();

            $table->string('document_name', 255);
            $table->string('document_type', 150)->nullable();
            $table->string('document_number', 100)->nullable();

            $table->date('issue_date')->nullable();
            $table->date('incorporation_date')->nullable();

            $table->integer('folios_start')->nullable();
            $table->integer('folios_end')->nullable();
            $table->integer('folios_count')->nullable();

            $table->string('file_path', 500);
            $table->string('original_file_name', 255)->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->boolean('is_sensitive')->default(false);
            $table->string('verification_status', 50)->default('PENDIENTE');

            $table->text('observations')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legajo_documents');
    }
};