<?php

namespace App\Http\Controllers;

use App\TaskList;
use App\TaskLists;
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
            // $tasks = TaskList::all();
            $tasks = TaskList::orderBy('position')->get();
            // $tasks = TaskList::all();

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
    public function show(TaskList $taskList, $id)
    
    {
        if ( Gate::allows('user_create') ||  Gate::allows('administrator')) {
            $users = User::all();
            // $tasks = TaskList::all();
            $tasks = TaskLists::where('tasklist_id',$id)->orderBy('position')->get();

            return view('back.pages.tasklist.task-view',compact('tasks', 'users', 'id'));
      }else{
          return abort(401);
      }




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
    public function storeLists(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignee' => 'required|exists:users,id',
        ]);

        // Create a new TaskList instance
        $taskList = new TaskLists();
        $taskList->tast = $validatedData['task'];
        $taskList->description = $validatedData['description'];
        $taskList->user_id = $validatedData['assignee'];
        $taskList->tasklist_id = $request->tasklist_id;
        $taskList->save();
        // return response()->json(['message' => 'Tasks deleted successfully']);

        // Optionally, you can add a success message
        session()->flash('success', 'Task added successfully');

        // Redirect back to the previous page or any other page you desire
        return redirect()->back();
    }
    public function updateOrders(Request $request)
    {
        $newOrder = $request->input('newOrder');
    
        foreach ($newOrder as $position => $taskId) {
            TaskLists::where('id', $taskId)->update(['position' => $position + 1]);
        }
    
        // Retrieve the updated task list data
        $updatedTaskLists = TaskLists::orderBy('position')->get();
        
        // Render the table view
        // return  $table = View::make('back.pages.tasklist.table', ['taskLists' => $updatedTaskLists])->render();
    
        return response()->json([
            'message' => 'Task order updated successfully',
            'taskLists' => $updatedTaskLists,
            // 'table' => $table, // Include the rendered table HTML
        ]);
    }
    public function updateOrder(Request $request)
    {
        $newOrder = $request->input('newOrder');
    
        foreach ($newOrder as $position => $taskId) {
            TaskList::where('id', $taskId)->update(['position' => $position + 1]);
        }
    
        // Retrieve the updated task list data
        $updatedTaskLists = TaskList::orderBy('position')->get();
        
        // Render the table view
        // return  $table = View::make('back.pages.tasklist.table', ['taskLists' => $updatedTaskLists])->render();

        return response()->json([
            'message' => 'Task order updated successfully',
            'taskLists' => $updatedTaskLists,
            // 'table' => $table, // Include the rendered table HTML
        ]);
    }
}
