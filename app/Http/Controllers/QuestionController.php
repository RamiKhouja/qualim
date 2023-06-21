<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Lot;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::orderBy('order','asc')->where('role','=', 'eleveur')->paginate();
        $colquests = Question::orderBy('order','asc')->where('role','=', 'collecteur')->paginate();
        $indquests = Question::orderBy('order','asc')->where('role','=', 'industrie')->paginate();
        $disquests = Question::orderBy('order','asc')->where('role','=', 'distributeur')->paginate();
        return view('admin.questions.index', compact(['questions', 'colquests', 'indquests', 'disquests']));
    }

    public function indexEleveur(Request $request, $lot_id)
    {
        $lot = Lot::find($lot_id);
        $phase = $lot->phase;
        $questions = Question::orderBy('order','asc')->where('role','=', 'eleveur')->paginate();

        if($phase == 1) {
            $questions = Question::orderBy('order','asc')->where('role','=', 'eleveur')->paginate();
        } elseif($phase == 2) {
            $questions = Question::orderBy('order','asc')->where('role','=', 'collecteur')->paginate();
        } elseif($phase == 3) {
            $questions = Question::orderBy('order','asc')->where('role','=', 'industrie')->paginate();
        } elseif($phase == 4) {
            $questions = Question::orderBy('order','asc')->where('role','=', 'distributeur')->paginate();
        }
        
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
    public function edit(Request $request, $lot_id)
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
