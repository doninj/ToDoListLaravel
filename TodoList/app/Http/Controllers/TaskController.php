<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(CreateTaskRequest $request) {
        $user = Auth::user();
        if (!$user) {
            return response()->json('Unauthorized', 401);
        }
        $validatedData = $request->validated();
        $task = $user->tasks()->create($validatedData);

        return (new TaskResource($task))->response()->setStatusCode(201);
    }
}
