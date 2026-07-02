<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Legajo;
use App\Models\LegajoDocument;
use App\Models\LegajoSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLegajoDocumentController extends Controller
{
    public function index(int $legajoId): JsonResponse
    {
        $legajo = Legajo::findOrFail($legajoId);

        $documents = LegajoDocument::with([
                'section:id,number,name',
            ])
            ->where('legajo_id', $legajo->id)
            ->orderBy('legajo_section_id')
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $documents,
        ]);
    }

    public function store(Request $request, int $legajoId): JsonResponse
    {
        $legajo = Legajo::findOrFail($legajoId);

        $validated = $request->validate([
            'legajo_section_id' => ['required', 'integer', 'exists:legajo_sections,id'],
            'document_name' => ['required', 'string', 'max:255'],
            'document_type' => ['nullable', 'string', 'max:150'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'issue_date' => ['nullable', 'date'],
            'incorporation_date' => ['nullable', 'date'],
            'folios_start' => ['nullable', 'integer', 'min:1'],
            'folios_end' => ['nullable', 'integer', 'min:1'],
            'is_sensitive' => ['nullable', 'boolean'],
            'verification_status' => ['nullable', 'string', 'max:50'],
            'observations' => ['nullable', 'string'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'legajo_section_id.required' => 'Debe seleccionar la sección del legajo.',
            'legajo_section_id.exists' => 'La sección seleccionada no es válida.',
            'document_name.required' => 'El nombre del documento es obligatorio.',
            'file.required' => 'Debe adjuntar un archivo PDF.',
            'file.mimes' => 'El archivo debe ser un PDF.',
            'file.max' => 'El archivo PDF no debe superar los 10 MB.',
        ]);

        $section = LegajoSection::findOrFail($validated['legajo_section_id']);

        $file = $request->file('file');

        $directory = 'legajos/' . $legajo->id . '/seccion-' . str_pad($section->number, 2, '0', STR_PAD_LEFT);

        $fileName = now()->format('YmdHis') . '_' . uniqid() . '.pdf';

        $filePath = $file->storeAs($directory, $fileName, 'public');

        $foliosCount = null;

        if (!empty($validated['folios_start']) && !empty($validated['folios_end'])) {
            $foliosCount = max(0, ((int) $validated['folios_end'] - (int) $validated['folios_start']) + 1);
        }

        $document = LegajoDocument::create([
            'legajo_id' => $legajo->id,
            'legajo_section_id' => $section->id,
            'document_name' => $validated['document_name'],
            'document_type' => $validated['document_type'] ?? null,
            'document_number' => $validated['document_number'] ?? null,
            'issue_date' => $validated['issue_date'] ?? null,
            'incorporation_date' => $validated['incorporation_date'] ?? now()->toDateString(),
            'folios_start' => $validated['folios_start'] ?? null,
            'folios_end' => $validated['folios_end'] ?? null,
            'folios_count' => $foliosCount,
            'file_path' => $filePath,
            'original_file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'is_sensitive' => $request->boolean('is_sensitive'),
            'verification_status' => $validated['verification_status'] ?? 'PENDIENTE',
            'observations' => $validated['observations'] ?? null,
        ]);

        $document->load('section:id,number,name');

        $legajo->update([
            'folios_total' => LegajoDocument::where('legajo_id', $legajo->id)->sum('folios_count'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Documento PDF incorporado correctamente al legajo.',
            'data' => $document,
        ], 201);
    }

    public function destroy(int $legajoId, int $documentId): JsonResponse
    {
        $legajo = Legajo::findOrFail($legajoId);

        $document = LegajoDocument::where('legajo_id', $legajo->id)
            ->where('id', $documentId)
            ->firstOrFail();

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        $legajo->update([
            'folios_total' => LegajoDocument::where('legajo_id', $legajo->id)->sum('folios_count'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Documento eliminado correctamente del legajo.',
        ]);
    }
}