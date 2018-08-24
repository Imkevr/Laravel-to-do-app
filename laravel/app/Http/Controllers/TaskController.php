<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $tasks = Task::orderBy('id','desc')->paginate(5); //new task will show on top of task list
      return view('tasks.index ')->with('taskData', $tasks);

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
        $this->validate($request, [
            'newTaskName' => 'required|min:3|max:255',
            'newTaskDescription' => 'required|min:5|max:300',
            'newDueDate'=> 'required|min:8',
        ]);

        $task = new Task;
        $task->name = $request->newTaskName;
        $task->description = $request->newTaskDescription;
        $task->taskCompleted = false;
        $task->dueDate = $request->newDueDate;
        $task->save();

        Session::flash('success','Een nieuwe taak is toegevoegd aan jouw lijst.');

        return redirect()->route('tasks.index');//redirect to /task page
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $task= Task::find($id);

            return view('tasks.edit ')->with('currentTask', $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $this->validate($request, [
            'updateName' => 'required|min:5|max:255|' ,
            'updateTaskDescription' => 'required|min:5|max:300',
            'updateDueDate'=> 'required',
            ]);

            $task = Task::find($id);
            $task->name = $request->updateName;
            $task->description = $request->updateTaskDescription;
            $task->dueDate = $request->updateDueDate;
            $task->save();
        
            Session::flash('success', 'Taak "'. $task->name.'" is bijgewerkt');
            return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $task = Task::find($id);
        $task->delete();

        Session::flash('success', 'Taak met naam "'. $task->name.'" is verwijderd');
        
        return redirect()->route('tasks.index');

    }

    /**
     * complete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     */
    public function completeTask(Request $request, Task $task)
    {
        $task = Task::find($request->completeTaskId);
        $task->taskCompleted = true;
        $task->save();

        Session::flash('success', 'Taak met naam "'. $task->name.'" is voltooid.');
        return redirect()->route('tasks.index');
           
    }
    
}

