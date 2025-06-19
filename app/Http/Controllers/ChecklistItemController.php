<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\JsonResponse;

class ChecklistItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); 
    }

    public function store(Request $request, $checklistId): JsonResponse
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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:proses,selesai'
        ]);

        $validated['checklist_id'] = $checklistId;
        $item = ChecklistItem::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dibuat',
            'data' => $item
        ], 201);
    }

    public function index($checklistId): JsonResponse
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

        $items = ChecklistItem::where('checklist_id', $checklistId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data items berhasil diambil',
            'data' => $items
        ]);
    }
    public function updateStatus(Request $request, $checklistId, $checklistItemId): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:proses,selesai'
        ]);

        $checklist = Checklist::where('user_id', auth('api')->id())
                             ->where('id', $checklistId)
                             ->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist tidak ditemukan'
            ], 404);
        }

        $item = ChecklistItem::where('checklist_id', $checklistId)
                           ->where('id', $checklistItemId)
                           ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $item->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status item berhasil diupdate',
            'data' => $item->fresh()
        ]);
    }

    public function destroy($checklistId, $checklistItemId): JsonResponse
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

        $item = ChecklistItem::where('checklist_id', $checklistId)
                           ->where('id', $checklistItemId)
                           ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus'
        ]);
    }

    public function rename(Request $request, $checklistId, $checklistItemId): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $checklist = Checklist::where('user_id', auth('api')->id())
                             ->where('id', $checklistId)
                             ->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist tidak ditemukan'
            ], 404);
        }

        $item = ChecklistItem::where('checklist_id', $checklistId)
                           ->where('id', $checklistItemId)
                           ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $item->update(['name' => $validated['name']]);

        return response()->json([
            'success' => true,
            'message' => 'Nama item berhasil diubah',
            'data' => $item->fresh()
        ]);
    }

    public function show($checklistId, $checklistItemId): JsonResponse
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

        $item = ChecklistItem::where('checklist_id', $checklistId)
                           ->where('id', $checklistItemId)
                           ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail item berhasil diambil',
            'data' => $item
        ]);
    }
}
