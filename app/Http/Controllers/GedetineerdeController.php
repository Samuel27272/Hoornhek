<?php

namespace App\Http\Controllers;

use App\Models\Cel;
use App\Models\Gedetineerde;
use Illuminate\Http\Request;

class GedetineerdeController extends Controller
{
    /** Display a listing of the resource. */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Gedetineerde::with('cel');
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('voornaam', 'like', "%{$q}%")
                    ->orWhere('achternaam', 'like', "%{$q}%")
                    ->orWhere('bsn_nummer', 'like', "%{$q}%")
                    ->orWhere('straatnaam', 'like', "%{$q}%")
                    ->orWhere('huisnummer', 'like', "%{$q}%");
            });
        }

        $gedetineerden = $query->orderBy('achternaam')->paginate(15)->withQueryString();

        return view('gedetineerden.index', compact('gedetineerden', 'q'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        $gedetineerde = new Gedetineerde;
        $cellen = Cel::where('status', 'beschikbaar')->orderBy('cel_nummer')->get();

        return view('gedetineerden.create', compact('gedetineerde', 'cellen'));
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'bsn_nummer' => 'required|string',
            'voornaam' => 'required|string',
            'achternaam' => 'required|string',
            'geboortedatum' => 'required|date',
            'straatnaam' => 'nullable|string',
            'huisnummer' => 'nullable|numeric',
            'postcode' => 'nullable|string',
            'woonplaats' => 'nullable|string',
            'telefoonnummer' => 'nullable|string',
            'email' => 'nullable|email',
            'aanhoudingsdatum' => 'nullable|date',
            'datum_schorsing' => 'nullable|date',
            'cel_id' => 'nullable|exists:cellen,id',
            'opmerkingen' => 'nullable|string',
        ]);

        // Mark cell as occupied when creating new gedetineerde
        if ($data['cel_id'] ?? null) {
            $cel = Cel::find($data['cel_id']);
            if ($cel) {
                /** @var \App\Models\Cel $cel */
                $cel->update(['status' => 'bezet']);
            }
        }

        Gedetineerde::create($data);

        return redirect()->route('gedetineerden.index')->with('success', 'Gedetineerde aangemaakt.');
    }

    /** Display the specified resource. */
    public function show(Gedetineerde $gedetineerden)
    {
        $gedetineerden->load('cel', 'documenten', 'zaken');

        return view('gedetineerden.show', ['gedetineerde' => $gedetineerden]);
    }

    /** Show the form for editing the specified resource. */
    public function edit(Gedetineerde $gedetineerden)
    {
        $gedetineerde = $gedetineerden;
        $cellen = Cel::where('status', 'beschikbaar')
            ->orWhere('id', $gedetineerde->cel_id)
            ->orderBy('cel_nummer')
            ->get();

        return view('gedetineerden.edit', compact('gedetineerde', 'cellen'));
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, Gedetineerde $gedetineerden)
    {
        $data = $request->validate([
            'bsn_nummer' => 'required|string',
            'voornaam' => 'required|string',
            'achternaam' => 'required|string',
            'geboortedatum' => 'required|date',
            'straatnaam' => 'nullable|string',
            'huisnummer' => 'nullable|numeric',
            'postcode' => 'nullable|string',
            'woonplaats' => 'nullable|string',
            'telefoonnummer' => 'nullable|string',
            'email' => 'nullable|email',
            'aanhoudingsdatum' => 'nullable|date',
            'datum_schorsing' => 'nullable|date',
            'cel_id' => 'nullable|exists:cellen,id',
            'opmerkingen' => 'nullable|string',
        ]);

        // Handle cell status changes
        $oldCelId = $gedetineerden->cel_id;
        $newCelId = $data['cel_id'] ?? null;

        // If cell assignment changed
        if ($oldCelId !== $newCelId) {
            // Release old cell if it's empty
            if ($oldCelId) {
                $oldCel = Cel::find($oldCelId);
                /** @var \App\Models\Cel $oldCel */
                if ($oldCel && $oldCel->gedetineerden()->count() === 1) {
                    $oldCel->update(['status' => 'beschikbaar']);
                }
            }

            // Mark new cell as occupied
            if ($newCelId) {
                $newCel = Cel::find($newCelId);
                if ($newCel) {
                    /** @var \App\Models\Cel $newCel */
                    $newCel->update(['status' => 'bezet']);
                }
            }
        }

        $gedetineerden->update($data);

        return redirect()->route('gedetineerden.index')->with('success', 'Wijzigingen opgeslagen.');
    }

    /** Remove the specified resource from storage. */
    public function destroy(Gedetineerde $gedetineerden)
    {
        $celId = $gedetineerden->cel_id;

        $gedetineerden->delete();

        // Release cell if it becomes empty
        if ($celId) {
            $cel = Cel::find($celId);
            /** @var \App\Models\Cel $cel */
            if ($cel && $cel->gedetineerden()->count() === 0) {
                $cel->update(['status' => 'beschikbaar']);
            }
        }

        return redirect()->route('gedetineerden.index')->with('success', 'Gedetineerde verwijderd.');
    }
}
