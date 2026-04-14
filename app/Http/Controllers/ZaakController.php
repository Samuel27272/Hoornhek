<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Zaak;
use Illuminate\Http\Request;

class ZaakController extends Controller
{
    /** Display a listing of the resource. */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Zaak::with('aangemaaktDoor');
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('zaaknummer', 'like', "%{$q}%")
                    ->orWhere('omschrijving', 'like', "%{$q}%")
                    ->orWhere('misdaad_type', 'like', "%{$q}%");
            });
        }

        $zaken = $query->orderBy('zaaknummer')->paginate(15)->withQueryString();

        return view('zaken.index', compact('zaken', 'q'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        $zaak = new Zaak;

        return view('zaken.create', compact('zaak'));
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'zaaknummer' => 'required|string',
            'omschrijving' => 'required|string',
            'misdaad_type' => 'nullable|string',
            'status' => 'required|in:open,gesloten,in_behandeling',
            'opmerkingen' => 'nullable|string',
        ]);

        $data['datum_aangemaakt'] = now()->toDateString();
        $data['aangemaakt_door'] = Auth::id();

        Zaak::create($data);

        return redirect()->route('zaken.index')->with('success', 'Zaak aangemaakt.');
    }

    /** Display the specified resource. */
    public function show(Zaak $zaken)
    {
        $zaken->load('aangemaaktDoor', 'gedetineerden');

        return view('zaken.show', ['zaak' => $zaken]);
    }

    /** Show the form for editing the specified resource. */
    public function edit(Zaak $zaken)
    {
        return view('zaken.edit', ['zaak' => $zaken]);
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, Zaak $zaken)
    {
        $data = $request->validate([
            'zaaknummer' => 'required|string',
            'omschrijving' => 'required|string',
            'misdaad_type' => 'nullable|string',
            'status' => 'required|in:open,gesloten,in_behandeling',
            'opmerkingen' => 'nullable|string',
        ]);

        if ($data['status'] === 'gesloten' && $zaken->status !== 'gesloten') {
            $data['datum_gesloten'] = now()->toDateString();
        }

        $zaken->update($data);

        return redirect()->route('zaken.index')->with('success', 'Wijzigingen opgeslagen.');
    }

    /** Remove the specified resource from storage. */
    public function destroy(Zaak $zaken)
    {
        $zaken->delete();

        return redirect()->route('zaken.index')->with('success', 'Zaak verwijderd.');
    }
}
