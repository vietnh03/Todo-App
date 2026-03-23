<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Todo::query();

        if ($request->has('status')) {
            $status = $request->status;
            if ($status == 1) {
                $query->where('status', 1);
            } elseif ($status == 0) {
                $query->where('status', 0);
            }
        }

        $total = Todo::count();
        $completedCount = Todo::where('status', 1)->count();

        $todos = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $todos,
            'meta' => [
                'total' => $total,
                'completed' => $completedCount
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'title' => $validated['title'],
            'status' => 0,
        ]);

        return response()->json($todo, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo->update([
            'title' => $validated['title'],
        ]);

        return response()->json($todo);
    }

    /**
     * Update status flag
     */
    public function updateStatus(Todo $todo)
    {
        $todo->update([
            'status' => !$todo->status,
        ]);

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(null, 204);
    }
}
