<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Historie;
use App\Models\Zaak;
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
        $alleZaken = Zaak::all();

        return view('gedetineerden.create', compact('gedetineerde', 'cellen', 'alleZaken'));
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
            'zaken' => 'nullable|array',
            'zaken.*' => 'exists:zaken,id',
        ]);

        if ($data['cel_id'] ?? null) {
            $cel = Cel::find($data['cel_id']);
            if ($cel) {
                /** @var \App\Models\Cel $cel */
                $cel->update(['status' => 'bezet']);
            }
        }

        $gedetineerde = Gedetineerde::create($data);

        if ($request->filled('zaken')) {
            $gedetineerde->zaken()->attach($request->zaken);
        }

        return redirect()->route('gedetineerden.index')->with('success', 'Gedetineerde aangemaakt.');
    }

    /** Display the specified resource. */
    public function show(Gedetineerde $gedetineerden)
    {
        $gedetineerden->load('cel', 'documenten', 'zaken', 'historie');

        return view('gedetineerden.show', ['gedetineerde' => $gedetineerden]);
    }

    /** Show the form for editing the specified resource. */
    public function edit(Gedetineerde $gedetineerden)
    {
        $gedetineerde = $gedetineerden;
        $gedetineerde->load('zaken');
        $cellen = Cel::where('status', 'beschikbaar')
            ->orWhere('id', $gedetineerde->cel_id)
            ->orderBy('cel_nummer')
            ->get();
        $alleZaken = Zaak::all();

        return view('gedetineerden.edit', compact('gedetineerde', 'cellen', 'alleZaken'));
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
            'zaken' => 'nullable|array',
            'zaken.*' => 'exists:zaken,id',
        ]);

        $oldCelId = $gedetineerden->cel_id;
        $newCelId = $data['cel_id'] ?? null;

        if ($oldCelId !== $newCelId) {
            if ($oldCelId) {
                $oldCel = Cel::find($oldCelId);
                /** @var \App\Models\Cel $oldCel */
                if ($oldCel && $oldCel->gedetineerden()->count() === 1) {
                    $oldCel->update(['status' => 'beschikbaar']);
                }
            }

            if ($newCelId) {
                $newCel = Cel::find($newCelId);
                if ($newCel) {
                    /** @var \App\Models\Cel $newCel */
                    $newCel->update(['status' => 'bezet']);
                }
            }
        }

        if ($oldCelId !== $newCelId) {
            $oudeCel = $oldCelId ? Cel::find($oldCelId)?->cel_nummer : '—';
            $nieuweCel = $newCelId ? Cel::find($newCelId)?->cel_nummer : '—';

            Historie::create([
                'gedetineerde_id' => $gedetineerden->id,
                'uitgevoerd_door' => Auth::user()->id,
                'gebeurtenis'     => "Verplaatst van cel {$oudeCel} naar cel {$nieuweCel}",
                'cel_oud'         => $oldCelId,
                'cel_nieuw'       => $newCelId,
                'type'            => 'overplaatsing',
                'datum'           => now(),
            ]);
        }

        $gedetineerden->update($data);
        $gedetineerden->zaken()->sync($request->zaken ?? []);

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

    public function uploadDocument(Request $request, Gedetineerde $gedetineerde)
    {
        $request->validate([
            'bestand'     => 'required|file|max:51200',
            'type'        => 'required|in:bewijs_document,bewijs_foto,bewijs_video,gespreksverslag,overig',
            'omschrijving' => 'nullable|string',
        ]);

        $bestand = $request->file('bestand');
        $pad = $bestand->store('documenten/' . $gedetineerde->id, 'public');

        Document::create([
            'gedetineerde_id' => $gedetineerde->id,
            'geupload_door'   => Auth::user()->id,
            'bestandsnaam'    => $bestand->getClientOriginalName(),
            'bestand_pad'     => $pad,
            'mime_type'       => $bestand->getMimeType(),
            'type'            => $request->type,
            'omschrijving'    => $request->omschrijving,
        ]);

        return back()->with('success', 'Document geüpload.');
    }

    public function verwijderDocument(Gedetineerde $gedetineerde, Document $document)
    {
        $rol = Auth::user()->rol;

        if ($rol === 'maatschappelijk_werker' && $document->type !== 'gespreksverslag') {
            abort(403, 'Geen toegang.');
        }

        Storage::disk('public')->delete($document->bestand_pad);
        $document->delete();

        return back()->with('success', 'Document verwijderd.');
    }

    public function ontslaan(Gedetineerde $gedetineerden)
    {
        if ($gedetineerden->cel_id) {
            $cel = Cel::find($gedetineerden->cel_id);
            /** @var \App\Models\Cel $cel */
            if ($cel && $cel->gedetineerden()->count() === 1) {
                $cel->update(['status' => 'beschikbaar']);
            }

            Historie::create([
                'gedetineerde_id' => $gedetineerden->id,
                'uitgevoerd_door' => Auth::user()->id,
                'gebeurtenis'     => "Gedetineerde ontslagen en cel {$cel->cel_nummer} vrijgegeven.",
                'cel_oud'         => $gedetineerden->cel_id,
                'cel_nieuw'       => null,
                'type'            => 'ontslag',
                'datum'           => now(),
            ]);
        }

        $gedetineerden->update([
            'status'          => 'inactief',
            'cel_id'          => null,
            'datum_schorsing' => now(),
        ]);

        return back()->with('success', 'Gedetineerde ontslagen.');
    }

    public function herplaatsen(Gedetineerde $gedetineerden)
    {
        $gedetineerden->update([
            'status'          => 'actief',
            'datum_schorsing' => null,
        ]);

        Historie::create([
            'gedetineerde_id' => $gedetineerden->id,
            'uitgevoerd_door' => Auth::user()->id,
            'gebeurtenis'     => "Gedetineerde opnieuw geactiveerd.",
            'cel_oud'         => null,
            'cel_nieuw'       => null,
            'type'            => 'overig',
            'datum'           => now(),
        ]);

        return back()->with('success', 'Gedetineerde opnieuw geactiveerd.');
    }
}
