<?php

namespace App\Http\Controllers;

use App\Models\Zaak;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        try {
            $data = $request->validate([
                'zaaknummer' => 'required|string|max:30|regex:/^[A-Za-z0-9\-]+$/',
                'omschrijving' => 'required|string|max:5000',
                'misdaad_type' => 'nullable|string|max:100',
                'status' => 'required|in:open,gesloten,in_behandeling',
                'opmerkingen' => 'nullable|string|max:2000',
            ]);

            $data['datum_aangemaakt'] = now()->toDateString();
            $data['aangemaakt_door'] = Auth::id();

            Zaak::create($data);

            return redirect()->route('zaken.index')->with('success', 'Zaak aangemaakt.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
    }

    /** Display the specified resource. */
    public function show(Zaak $zaak)
    {
        $zaak->load('aangemaaktDoor', 'gedetineerden');

        return view('zaken.show', ['zaak' => $zaak]);
    }

    /** Show the form for editing the specified resource. */
    public function edit(Zaak $zaak)
    {
        return view('zaken.edit', ['zaak' => $zaak]);
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, Zaak $zaak)
    {
        try {
            $data = $request->validate([
                'zaaknummer' => 'required|string|max:30|regex:/^[A-Za-z0-9\-]+$/',
                'omschrijving' => 'required|string|max:5000',
                'misdaad_type' => 'nullable|string|max:100',
                'status' => 'required|in:open,gesloten,in_behandeling',
                'opmerkingen' => 'nullable|string|max:2000',
            ]);

            if ($data['status'] === 'gesloten' && $zaak->status !== 'gesloten') {
                $data['datum_gesloten'] = now()->toDateString();
            }

            $zaak->update($data);

            return redirect()->route('zaken.index')->with('success', 'Wijzigingen opgeslagen.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
    }

    /** Remove the specified resource from storage. */
    public function destroy(Zaak $zaak)
    {
        Zaak::query()->whereKey($zaak->getKey())->delete();

        return redirect()->route('zaken.index')->with('success', 'Zaak verwijderd.');
    }
}
