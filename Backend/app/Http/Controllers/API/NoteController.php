<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function index($sectionId)
    {
        $notes = Note::where('section_id', $sectionId)->get();

        return response()->json([
            'success' => true,
            'data' => $notes
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip|max:10240',
            'is_premium' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $filePath = $request->file('file')->store('notes', 'public');
        $fileSize = $request->file('file')->getSize();

        // Convert to KB or MB for readability
        $formattedSize = $fileSize < 1024 * 1024
            ? round($fileSize / 1024, 2) . ' KB'
            : round($fileSize / (1024 * 1024), 2) . ' MB';

        $note = Note::create([
            'section_id' => $request->section_id,
            'title' => $request->title,
            'file' => $filePath,
            'file_size' => $formattedSize,
            'is_premium' => $request->is_premium ?? true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => $note
        ], 201);
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $note
        ]);
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip|max:10240',
            'is_premium' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->title,
            'is_premium' => $request->is_premium ?? true
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($note->file) {
                Storage::disk('public')->delete($note->file);
            }

            $filePath = $request->file('file')->store('notes', 'public');
            $fileSize = $request->file('file')->getSize();

            // Convert to KB or MB for readability
            $formattedSize = $fileSize < 1024 * 1024
                ? round($fileSize / 1024, 2) . ' KB'
                : round($fileSize / (1024 * 1024), 2) . ' MB';

            $data['file'] = $filePath;
            $data['file_size'] = $formattedSize;
        }

        $note->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => $note
        ]);
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);

        // Delete file
        if ($note->file) {
            Storage::disk('public')->delete($note->file);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ]);
    }
}

