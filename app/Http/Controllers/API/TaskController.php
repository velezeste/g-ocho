<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

/**
* @OA\Info(title="API G-OCHO", version="1.0")
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

class TaskController extends Controller
{
    // all tasks
    /**
    * @OA\Get(
    *     path="/api/tasks",
    *     summary="Mostrar tareas",
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar todas las tareas."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function index()
    {
        $tasks = Task::all()->toArray();
        return array_reverse($tasks);
    }
    
    public function add(Request $request)
    {
        $task = new Task([
            'task' => $request->task,
            'detail' => $request->detail,
            'dataEnd' => $request->dataEnd,
            'user_id' => $request->user_id,
            'author' => $request->author,
            'state' => $request->state
        ]);
        $task->save();

        return response()->json('The task successfully added');
    }

    // edit task
    public function edit($id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }

    // update task
    public function update($id, Request $request)
    {
        $task = Task::find($id);
        $task->update($request->all());

        return response()->json('The task successfully updated');
    }

    // delete task
    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();

        return response()->json('The task successfully deleted');
    }
}