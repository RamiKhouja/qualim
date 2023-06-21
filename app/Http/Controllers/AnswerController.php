<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\User;
use App\Models\Lot;
use App\Models\LotUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function indexByLots()
    {
        $answers = Answer::with('lot', 'question')
            ->orderBy('lot_id')
            ->get()
            ->groupBy('lot_id');

        return view('admin.answers.index', compact('answers'));
    }

    public function indexRequests()
    {
        $collectorId = Auth::id();

        $answers = Answer::with(['lot' => function ($query) use ($collectorId) {
            $query
            ->whereHas('destinations', function ($subQuery) use ($collectorId) {
                $subQuery->where('user_id', $collectorId)
                    ->where('in_progress', true);
            });
        }, 'question'])
        ->orderBy('lot_id')
        ->get()
        ->groupBy('lot_id');

        return view('client.requests.index', compact('answers'));
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
        $lot_id = (int)$request->input('lot_id');
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
                'validation_text' => '',
                'lot_id' => $lot_id
            ]);
        }
        // edit lot in progress
        $lot = Lot::find($lot_id);
        if($lot) {
            $lot->in_progress = true;
            $lot->save();
        }
        $lotUsers = LotUser::where('lot_id', $lot->id)->get();
        foreach($lotUsers as $lotUser) {
            $lotUser->in_progress = true;
            $lotUser->save();
        }

        return redirect()->route('lots')->with('success','Votre réponse va être étudiée.');
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
