<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $task = TaskResource::collection(
            Task::paginate(50)
        );

        return $task;
    }

    public function search($query)
    {
        $tasks = TaskResource::collection(
            Task::where('title', 'LIKE', "%{$query}%")
                ->orWhere('slug', 'LIKE', "%{$query}%")
                ->paginate(30)
        );

        return $tasks;
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tasks',
            'description' => 'required'
        ]);

        $task = new Task([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description
        ]);

        if ($task->save()) {
            return response()->json(['message' => 'Task created.']);
        }
    }

    public function update(Request $request, Task $task, $id)
    {
        $request->validate([
            'title' => 'required|unique:tasks',
            'description' => 'required'
        ]);

        $task = $task::findOrFail($id);


        $task->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description
        ]);

        if ($task->save()) {
            return response()->json(['message' => 'Task updated.']);
        }
    }

    public function assign(Request $request, Task $task, $id)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        $task = $task::findOrFail($id);

        $task->update([
            'user_id' => $request->user_id,
            'assigned_on' => now(),
            'status' => 'pending'
        ]);

        if ($task->save()) {
            return response()->json(['message' => 'Task assigned.']);
        }
    }

    public function close(Request $request, Task $task, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $task = $task::findOrFail($id);

        $task->update([
            'status' => $request->status,
            'closed_on' => now()
        ]);

        if ($task->save()) {
            return response()->json(['message' => 'Task closed.']);
        }
    }

    public function delete(Task $task, $id)
    {
        $task = $task::findOrFail($id);

        if ($task->delete()) {
            return response()->json(['message' => 'Task deleted.']);
        }
    }
}
