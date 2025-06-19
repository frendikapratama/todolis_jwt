<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklist;
use Illuminate\Http\JsonResponse;

class ChecklistController extends Controller
{
   public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $checklist = Checklist::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Checklist berhasil dibuat',
            'data' => $checklist
        ], 201);
    }

    // 2. Menghapus checklist
    public function destroy($checklistId): JsonResponse
    {
        $checklist = Checklist::find($checklistId);

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist tidak ditemukan'
            ], 404);
        }

        $checklist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Checklist berhasil dihapus'
        ]);
    }

    // 3. Menampilkan semua checklist
    public function index(): JsonResponse
    {
        $checklists = Checklist::all();

        return response()->json([
            'success' => true,
            'message' => 'Data checklist berhasil diambil',
            'data' => $checklists
        ]);
    }

    // 4. Detail checklist beserta items
    public function show($id): JsonResponse
    {
        $checklist = Checklist::with('items')->find($id);

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail checklist berhasil diambil',
            'data' => $checklist
        ]);
    }
}

