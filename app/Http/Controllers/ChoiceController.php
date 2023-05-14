<?php

namespace App\Http\Controllers;
use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $choices =Choice::orderBy('id','desc')->paginate(10);
        return view('admin.choices', compact('choices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $question_id)
    {
        $choices = Choice::select('id', 'value', 'question_id')->where('question_id','=', $question_id)->paginate(10);
        return view('admin.choices.create', compact('choices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->question_id = (int)$request->input('question_id');
        $request->validate([
            'value' => 'required',
            'question_id' => ['required', 'integer']
        ]);
        Choice::create($request->post());
        return redirect()->route('admin.choices.create', ['question_id' => $request->question_id]);
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
