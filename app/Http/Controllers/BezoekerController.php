<?php

namespace App\Http\Controllers;

use App\Models\Bezoeker;
use Illuminate\Http\Request;

class BezoekerController extends Controller
{
    /** Display a listing of the resource. */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Bezoeker::query();
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('voornaam', 'like', "%{$q}%")
                    ->orWhere('achternaam', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('telefoonnummer', 'like', "%{$q}%");
            });
        }

        $bezoekers = $query->orderBy('achternaam')->paginate(15)->withQueryString();

        return view('bezoekers.index', compact('bezoekers', 'q'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        $bezoeker = new Bezoeker;

        return view('bezoekers.create', compact('bezoeker'));
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'voornaam' => 'required|string',
            'achternaam' => 'required|string',
            'telefoonnummer' => 'nullable|string',
            'email' => 'nullable|email',
            'start_bezoek' => 'nullable|date_format:Y-m-d\TH:i',
            'status' => 'required|in:op_bezoek,inactief',
        ]);

        Bezoeker::create($data);

        return redirect()->route('bezoekers.index')->with('success', 'Bezoeker aangemaakt.');
    }

    /** Display the specified resource. */
    public function show(Bezoeker $bezoeker)
    {
        return view('bezoekers.show', compact('bezoeker'));
    }

    /** Show the form for editing the specified resource. */
    public function edit(Bezoeker $bezoeker)
    {
        return view('bezoekers.edit', compact('bezoeker'));
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, Bezoeker $bezoeker)
    {
        $data = $request->validate([
            'voornaam' => 'required|string',
            'achternaam' => 'required|string',
            'telefoonnummer' => 'nullable|string',
            'email' => 'nullable|email',
            'start_bezoek' => 'nullable|date_format:Y-m-d\TH:i',
            'status' => 'required|in:op_bezoek,inactief',
        ]);

        $bezoeker->update($data);

        return redirect()->route('bezoekers.index')->with('success', 'Wijzigingen opgeslagen.');
    }

    /** Remove the specified resource from storage. */
    public function destroy(Bezoeker $bezoeker)
    {
        $bezoeker->delete();

        return redirect()->route('bezoekers.index')->with('success', 'Bezoeker verwijderd.');
    }
}
