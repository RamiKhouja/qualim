<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lot;
use App\Models\User;
use App\Models\LotUser;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function myIndex()
    {
        $userId = Auth::id();
        
        // Retrieve lots owned by the connected user
        $lots = Lot::where('owner', $userId)->get();
        return view('client.lots.index', compact('lots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Auth::user()->role;
        $destinations = null;

        if($role == 'eleveur') {
            $destinations = User::where('role', 'collecteur')->get();
        }
        elseif($role == 'collecteur') {
            $destinations = User::where('role', 'industrie')->get();
        }
        elseif($role == 'industrie') {
            $destinations = User::where('role', 'distributeur')->get();
        }
        else { $destinations = null; }

        $receivedLots = null;
        if($role == 'collecteur' || $role == 'industrie' || $role == 'distributeur') {
            $destId = auth()->id();
            $receivedLots = Lot::whereHas('destinations', function ($query) use ($destId) {
                $query->where('user_id', $destId)
                    ->where('valid', true);
            })->get();
        }
        return view('client.lots.create', compact(['destinations', 'receivedLots']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $owner = Auth::id();
        $destinations = $request->input('destinations');
        $childLotIds = null;
        $role = Auth::user()->role;
        if($role == 'collecteur' || $role=='industrie')
        { $childLotIds = $request->input('childlots'); }
        $phase = 1;
        if($role=='eleveur') $phase=1;
        elseif($role=='collecteur') $phase=2;
        elseif($role=='industrie') $phase=3;
        else $phase=4;
        // Lot::create($request->post());
        $lot = Lot::create([
            'num' => $request->num,
            'owner' => $owner,
            'phase' => $phase,
            'admin_valid' => false
        ]);

        foreach ($destinations as $destination) {
            $userDestination = User::findOrFail($destination);
            LotUser::create([
                'lot_id' => $lot->id,
                'user_id' => $userDestination->id,
                'valid' => false,
                'in_progress' => false
            ]);
        }

        if($childLotIds) {
            foreach ($childLotIds as $childLotId) {
                $childLot = Lot::find($childLotId);
                $childLot->parent_lot_id = $lot->id;
                $childLot->save();
            }
        }

        return redirect()->route('questions', ['lot_id' => $lot->id])
                        ->with('success','Votre Lot a été créé avec succès.');;
    }

    public function adminValid(Request $request, Lot $lot)
    {
        if ($request->has('accept')) {
            $lot->phase += 1;
            $lot->in_progress = false;
            $lot->admin_valid = true;
        } elseif ($request->has('reject')) {
            $lot->in_progress = false;
            $lot->admin_valid = false;
        }
        
        $lot->save();

        return redirect()->back()->with('success','Une validation est envoyée à l\'utilisateur');;
    }

    public function destValid(Request $request, Lot $lot)
    {
        $destinationId = auth()->id();
        $lotUser = LotUser::where('lot_id', $lot->id)
            ->where('user_id', $destinationId)
            ->first();

        if ($request->has('accept')) {
            $lot->phase += 1;
            $lotUser->valid = true;
        } elseif ($request->has('reject')) {
            $lotUser->valid = false;
        }

        $lotUser->in_progress = false;
        $lot->save();
        $lotUser->save();

        return redirect()->back()->with('success','Une validation est envoyée à l\'utilisateur');
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
