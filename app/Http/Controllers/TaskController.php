<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;

class TaskController extends Controller
{
    //
    public function index(Request $request)
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }
    public function create(Request $request)
    {
        // dd($request->date);
        $validateData = $request->validate([
            'name'     => 'required',
            'date'  => 'required',
        ]);

        Task::create($validateData);
        // Task::create([
        //     'name' => $request->name,
        //     'date' => $request->date
        // ]);

        return redirect('/')->with('message', 'Task SuccessFully Created...!!');
    }
}
