<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::orderBy('order','asc')->where('role','=', 'eleveur')->paginate(5);
        $colquests = Question::orderBy('order','asc')->where('role','=', 'collecteur')->paginate(5);
        $indquests = Question::orderBy('order','asc')->where('role','=', 'industrie')->paginate(5);
        $disquests = Question::orderBy('order','asc')->where('role','=', 'distributeur')->paginate(5);
        return view('admin.questions.index', compact(['questions', 'colquests', 'indquests', 'disquests']));
    }

    public function indexEleveur()
    {
        $questions = Question::orderBy('order','asc')->where('role','=', 'eleveur')->paginate(5);
        return view('client.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'type' => 'required',
            'role' => 'required',
            'order',
            'required' => 'boolean'
        ]);
        $request->required = isset($request->required) ? 1 : 0;
        
        $question = Question::create($request->post());
        
        if(in_array($request->type, ['checkbox', 'radio', 'select'])) {
            return redirect()->route('admin.choices.create', ['question_id' => $question->id]);
        } else {
            return redirect()->route('admin.questions')->with('success','Question has been created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
