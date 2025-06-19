<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklist;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller; 

class ChecklistController extends Controller
{
 
  public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $validated['user_id'] = auth('api')->id();
        $checklist = Checklist::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Checklist berhasil dibuat',
            'data' => $checklist
        ], 201);
    }

    public function destroy($checklistId): JsonResponse
    {
        $checklist = Checklist::where('user_id', auth('api')->id())
                             ->where('id', $checklistId)
                             ->first();

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

    public function index(): JsonResponse
    {
        $checklists = Checklist::where('user_id', auth('api')->id())->get();

        return response()->json([
            'success' => true,
            'message' => 'Data checklist berhasil diambil',
            'data' => $checklists
        ]);
    }

    public function show($id): JsonResponse
    {
        $checklist = Checklist::with('items')
                             ->where('user_id', auth('api')->id())
                             ->where('id', $id)
                             ->first();

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

