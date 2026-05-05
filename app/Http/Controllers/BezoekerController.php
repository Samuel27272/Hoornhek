<?php

namespace App\Http\Controllers;

use App\Models\Bezoeker;
use Illuminate\Database\QueryException;
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

        $bezoekers = $query->orderBy('achternaam', 'asc')->paginate(15)->withQueryString();

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
        try {
            $data = $request->validate([
                'voornaam' => 'required|string|max:255',
                'achternaam' => 'required|string|max:255',
                'telefoonnummer' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'start_bezoek' => 'nullable|date_format:Y-m-d\TH:i',
                'status' => 'required|in:op_bezoek,inactief',
            ]);

            Bezoeker::create($data);

            return redirect()->route('bezoekers.index')->with('success', 'Bezoeker aangemaakt.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
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
        try {
            $data = $request->validate([
                'voornaam' => 'required|string|max:255',
                'achternaam' => 'required|string|max:255',
                'telefoonnummer' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'start_bezoek' => 'nullable|date_format:Y-m-d\TH:i',
                'status' => 'required|in:op_bezoek,inactief',
            ]);

            $bezoeker->update($data);

            return redirect()->route('bezoekers.index')->with('success', 'Wijzigingen opgeslagen.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
    }

    /** Remove the specified resource from storage. */
    public function destroy(Bezoeker $bezoeker)
    {
        Bezoeker::query()->whereKey($bezoeker->getKey())->delete();

        return redirect()->route('bezoekers.index')->with('success', 'Bezoeker verwijderd.');
    }
}
