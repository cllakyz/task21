<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    use ApiResponser;

    /**
     * Tasks list
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();

        return $this->successResponse(TaskResource::collection($tasks), __('Tasks retrieved successfully.'));
    }

    /**
     * Task create
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $requestData = $request->all();

        $validate = Validator::make($requestData, [
            'title' => ['required', 'string', 'max:255']
        ]);

        if ($validate->fails()) {
            // return $this->errorResponse(__('Validation Error!'), (array)$validate->errors(), 422);
            return response()->json(['errors' => [
                'title' => [
                    'The title field is required.'
                ]
            ]], 422);
        }

        $requestData['user_id'] = Auth::id();

        $task = Task::create($requestData);
        if (!$task) {
            return $this->errorResponse(__('Task could\'t be created!'), [], 400);
        }

        return $this->successResponse(new TaskResource($task), __('Task created successfully.'), 201);
    }

    /**
     * Task detail
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return $this->successResponse(new TaskResource($task), __('Task retrieved successfully.'));
    }

    /**
     * Task update
     *
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $requestData = $request->all();

        $validate = Validator::make($requestData, [
            'title' => ['required', 'string', 'max:255']
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => [
                'title' => [
                    'The title field is required.'
                ]
            ]], 422);
        }

        $task->update($requestData);

        return $this->successResponse(new TaskResource($task), __('Task updated successfully.'));
    }

    /**
     * Delete task
     *
     * @param Task $task
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return $this->successResponse(new TaskResource($task), __('Task deleted successfully.'));
    }
}
