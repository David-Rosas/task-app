<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        try {
            return Inertia::render('Task/Index', [
                'tasks' => Auth::user()->tasks()
                    ->orderBy('created_at')
                    ->paginate(10)
                    ->through(fn($task) => [
                        'id' => $task->id,
                        'name' => $task->name,
                        'description' => $task->description,
                        'status' => $task->status(),
                        'created_at' => $task->created_at,
                    ]),
            ]);
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function create()
    {
        return Inertia::render('Task/Create');
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:100'],
                'description' => ['nullable'],
            ]);

            if ($validator->fails()) {

                return response()->json(
                    [
                        'success' => false,
                        'message' => $validator->errors()->first(),
                        'error' => $validator->errors(),
                        'status' => 406,
                    ],
                    406
                );
            }

            $input = $request->all();

            Auth::user()->tasks()->create([
                'name' => $input['name'],
                'description' => $input['description'],
                'user_id' => Auth::user()->id,
                'status_task_id' => 1,
            ]
            );

            return Redirect::route('task')->with('success', 'Task created.');
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function edit(Task $task)
    {
        try {
            return Inertia::render('Task/Edit', [
                'task' => [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => $task->description,
                    'status_task_id' => $task->status_task_id,
                ],
            ]);
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function update(Request $request, Task $task)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:100'],
                'status_task_id' => ['required'],
            ]);

            if ($validator->fails()) {

                return response()->json(
                    [
                        'success' => false,
                        'message' => $validator->errors()->first(),
                        'error' => $validator->errors(),
                        'status' => 406,
                    ],
                    406
                );
            }

            $input = $request->all();

            $task->update(
                [
                    'name' => $input['name'],
                    'description' => $input['description'],
                    'user_id' => Auth::user()->id,
                    'status_task_id' => $input['status_task_id'],
                ]
            );

            return Redirect::route('task')->with('success', 'Task updated.');
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return Redirect::route('task')->with('success', 'Task deleted.');
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function restore(Task $task)
    {
        try {
            $task->restore();

            return Redirect::route('task')->with('success', 'Task restored.');
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }
}
