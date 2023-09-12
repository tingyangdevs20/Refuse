<?php

namespace App\Http\Controllers;

use App\TaskList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('user_module') || Gate::allows('administrator')) {

            $users = User::all();
            $tasks = TaskList::all();

            return view('back.pages.tasklist.index',compact('users','tasks'));
        }else{
            return abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( Gate::allows('user_create') ||  Gate::allows('administrator')) {

            // Validate the form data
            $validatedData = $request->validate([
              'task' => 'required|string|max:255',
              'assignee' => 'required',

          ]);


          // Create a new user instance
          $task = new TaskList([
              'tast' => $validatedData['task'],
              'user_id' => $validatedData['assignee'],
              'checked' => 1,
              'status' => 'assignee',

          ]);

          // Save the user data
          $task->save();

          // Assign roles using Spatie's role package

          session()->flash('success', 'Task has been created !!');
          return redirect()->route('admin.task-list.index');
      }else{
          return abort(401);
      }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function show(TaskList $taskList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskList $taskList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $task = TaskList::findOrFail($request->id);
        $task->update([
            'tast' => $request->input('task'),
            'user_id' => $request->input('assignee'),
            // Add other fields as needed
        ]);

        return response()->json(['message' => 'Task updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

        $taskIds = $request->input('task_id');
        TaskList::whereIn('id', $taskIds)->delete();

        return response()->json(['message' => 'Tasks deleted successfully']);


    }
}
