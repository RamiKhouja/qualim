<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function indexByUsers()
    {
        // $answers = Answer::with('user')
        //     ->orderBy('user_id')
        //     ->get()
        //     ->groupBy('user_id');

        $answers = Answer::with('user', 'question')
            ->where(function ($query) {
                $query->where(function ($subquery) {
                    $subquery->whereHas('user', function ($userQuery) {
                        $userQuery->where('phase', 1);
                    })->whereHas('question', function ($questionQuery) {
                        $questionQuery->where('role', 'eleveur');
                    });
                })
                ->orWhere(function ($subquery) {
                    $subquery->whereHas('user', function ($userQuery) {
                        $userQuery->where('phase', 2);
                    })->whereHas('question', function ($questionQuery) {
                        $questionQuery->where('role', 'collecteur');
                    });
                })
                ->orWhere(function ($subquery) {
                    $subquery->whereHas('user', function ($userQuery) {
                        $userQuery->where('phase', 3);
                    })->whereHas('question', function ($questionQuery) {
                        $questionQuery->where('role', 'industrie');
                    });
                })
                ->orWhere(function ($subquery) {
                    $subquery->whereHas('user', function ($userQuery) {
                        $userQuery->where('phase', 4);
                    })->whereHas('question', function ($questionQuery) {
                        $questionQuery->where('role', 'distributeur');
                    });
                });
            })
            ->get()
            ->groupBy('user_id');

        return view('admin.answers.index', compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $answers = $request->input('answers');
        $user_id = (int)$request->input('user_id');
        //dump($answers);
        // dump($request->files);
        
        foreach ($answers as $questionId => $answerValue) {
            if(is_array($answerValue)){
                $answerValue = implode(', ', $answerValue);
            }
            // Create an answer for each question
            Answer::create([
                'user_id' => $user_id,
                'question_id' => $questionId,
                'answer' => $answerValue,
                'valid' => false,
                'validation_text' => ''
            ]);
        }
        // edit user in progress
        $user = User::find($user_id);
        if($user) {
            $user->in_progress = true;
            $user->save();
        }

        return redirect()->route('questions')->with('success','Votre réponse va être étudiée.');
    }

    public function userValid(Request $request, User $user)
    {
        if ($request->has('accept')) {
            $user->phase += 1;
            $user->in_progress = false;
        } elseif ($request->has('reject')) {
            $user->in_progress = false;
        }
        
        $user->save();

        return redirect()->back()->with('success','Une validation est envoyée à l\'utilisateur');;
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
    public function update(Request $request, Answer $answer)
    {
        $answer->update($request->all());
        return redirect()->back();
        // $answer->fill($request->post())->save();
        // return redirect()->route('admin.answers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
