<?php

namespace App\Http\Controllers;

use App\Models\Cel;
use App\Models\Document;
use App\Models\Gedetineerde;
use App\Models\Historie;
use App\Models\Zaak;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
                    ->orWhere('huisnummer', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "{$q}%");
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
        try {
            $data = $request->validate($this->gedetineerdeRules(), $this->gedetineerdeMessages());

            if ($data['cel_id'] ?? null) {
                $cel = Cel::find($data['cel_id']);
                if ($cel) {
                    /** @var Cel $cel */
                    $cel->update(['status' => 'bezet']);
                }
            }

            if ($request->hasFile('foto_pad')) {
                $data['foto_pad'] = $request->file('foto_pad')->store('fotos', 'public');
            }

            $gedetineerde = Gedetineerde::create($data);

            if ($request->filled('zaken')) {
                $gedetineerde->zaken()->attach($request->zaken);
            }

            return redirect()->route('gedetineerden.index')->with('success', 'Gedetineerde aangemaakt.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
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
        try {
            $data = $request->validate($this->gedetineerdeRules($gedetineerden), $this->gedetineerdeMessages());

            $oldCelId = $gedetineerden->cel_id;
            $newCelId = $data['cel_id'] ?? null;

            /** Als cel leeg is, op beschikbaar zetten */
            if ($oldCelId !== $newCelId) {
                if ($oldCelId) {
                    $oldCel = Cel::find($oldCelId);
                    /** @var Cel $oldCel */
                    if ($oldCel && $oldCel->gedetineerden()->count() === 1) {
                        $oldCel->update(['status' => 'beschikbaar']);
                    }
                }

                if ($newCelId) {
                    $newCel = Cel::find($newCelId);
                    if ($newCel) {
                        /** @var Cel $newCel */
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
                    'gebeurtenis' => "Verplaatst van cel {$oudeCel} naar cel {$nieuweCel}",
                    'cel_oud' => $oldCelId,
                    'cel_nieuw' => $newCelId,
                    'type' => 'overplaatsing',
                    'datum' => now(),
                ]);
            }

            if ($request->hasFile('foto_pad')) {
                if ($gedetineerden->foto_pad) {
                    Storage::disk('public')->delete($gedetineerden->foto_pad);
                }
                $data['foto_pad'] = $request->file('foto_pad')->store('fotos', 'public');
            } elseif ($request->boolean('foto_verwijderen')) {
                if ($gedetineerden->foto_pad) {
                    Storage::disk('public')->delete($gedetineerden->foto_pad);
                }
                $data['foto_pad'] = null;
            } else {
                unset($data['foto_pad']);
            }

            $gedetineerden->update($data);
            $gedetineerden->zaken()->sync($request->zaken ?? []);

            return redirect()->route('gedetineerden.index')->with('success', 'Wijzigingen opgeslagen.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
    }

    /** Remove the specified resource from storage. */
    public function destroy(Gedetineerde $gedetineerden)
    {
        $celId = $gedetineerden->cel_id;

        $gedetineerden->delete();

        /** bij verwijderen van gedetineerde cel op beschikbaar zetten */
        if ($celId) {
            $cel = Cel::find($celId);
            /** @var Cel $cel */
            if ($cel && $cel->gedetineerden()->count() === 0) {
                $cel->update(['status' => 'beschikbaar']);
            }
        }

        return redirect()->route('gedetineerden.index')->with('success', 'Gedetineerde verwijderd.');
    }

    /** Upload Document*/
    public function uploadDocument(Request $request, Gedetineerde $gedetineerde)
    {
        $request->validate([
            'bestand' => 'required|file|max:51200',
            'type' => 'required|in:bewijs_document,bewijs_foto,bewijs_video,gespreksverslag,overig',
            'omschrijving' => 'nullable|string',
        ]);

        $bestand = $request->file('bestand');
        $pad = $bestand->store('documenten/'.$gedetineerde->id, 'public');

        Document::create([
            'gedetineerde_id' => $gedetineerde->id,
            'geupload_door' => Auth::user()->id,
            'bestandsnaam' => $bestand->getClientOriginalName(),
            'bestand_pad' => $pad,
            'mime_type' => $bestand->getMimeType(),
            'type' => $request->type,
            'omschrijving' => $request->omschrijving,
        ]);

        return back()->with('success', 'Document geüpload.');
    }

    /** Verwijder Document */
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

    /** Ontsla Gedetineerde */
    public function ontslaan(Gedetineerde $gedetineerden)
    {
        if ($gedetineerden->cel_id) {
            $cel = Cel::find($gedetineerden->cel_id);
            /** @var Cel $cel */
            if ($cel && $cel->gedetineerden()->count() === 1) {
                $cel->update(['status' => 'beschikbaar']);
            }

            Historie::create([
                'gedetineerde_id' => $gedetineerden->id,
                'uitgevoerd_door' => Auth::user()->id,
                'gebeurtenis' => "Gedetineerde ontslagen en cel {$cel->cel_nummer} vrijgegeven.",
                'cel_oud' => $gedetineerden->cel_id,
                'cel_nieuw' => null,
                'type' => 'ontslag',
                'datum' => now(),
            ]);
        }

        $gedetineerden->update([
            'status' => 'inactief',
            'cel_id' => null,
            'datum_schorsing' => now(),
        ]);

        return back()->with('success', 'Gedetineerde ontslagen.');
    }

    /** Heractiveer gedetineerde */
    public function herplaatsen(Gedetineerde $gedetineerden)
    {
        $gedetineerden->update([
            'status' => 'actief',
            'datum_schorsing' => null,
        ]);

        Historie::create([
            'gedetineerde_id' => $gedetineerden->id,
            'uitgevoerd_door' => Auth::user()->id,
            'gebeurtenis' => 'Gedetineerde opnieuw geactiveerd.',
            'cel_oud' => null,
            'cel_nieuw' => null,
            'type' => 'overig',
            'datum' => now(),
        ]);

        return back()->with('success', 'Gedetineerde opnieuw geactiveerd.');
    }

    /**
     * Get validation rules for gedetineerden.
     *
     * @return array<string, array<int, mixed>|string>
     */
    private function gedetineerdeRules(?Gedetineerde $gedetineerde = null): array
    {
        return [
            'bsn_nummer' => [
                'required',
                'string',
                'size:9',
                'regex:/^[0-9]{9}$/',
                Rule::unique('gedetineerden', 'bsn_nummer')
                    ->ignore($gedetineerde?->id),
            ],
            'voornaam' => 'required|string|max:255',
            'achternaam' => 'required|string|max:255',
            'geboortedatum' => 'required|date',
            'straatnaam' => $gedetineerde?->exists ? 'required|string|max:255' : 'nullable|string|max:255',
            'huisnummer' => $gedetineerde?->exists ? 'required|numeric|min:1|max:99999' : 'nullable|numeric|min:1|max:99999',
            'postcode' => $gedetineerde?->exists ? 'required|string|max:7|regex:/^[1-9][0-9]{3}\s?[A-Za-z]{2}$/' : 'nullable|string|max:7|regex:/^[1-9][0-9]{3}\s?[A-Za-z]{2}$/',
            'woonplaats' => $gedetineerde?->exists ? 'required|string|max:255' : 'nullable|string|max:255',
            'telefoonnummer' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]{6,20}$/',
            'email' => 'nullable|email|max:255',
            'aanhoudingsdatum' => $gedetineerde?->exists ? 'required|date' : 'nullable|date',
            'datum_schorsing' => 'nullable|date',
            'cel_id' => 'nullable|exists:cellen,id',
            'opmerkingen' => 'nullable|string|max:2000',
            'zaken' => 'nullable|array',
            'zaken.*' => 'exists:zaken,id',
            'foto_pad' => 'nullable|image|max:5120',
        ];
    }

    /**
     * Get custom validation messages for gedetineerden.
     *
     * @return array<string, string>
     */
    private function gedetineerdeMessages(): array
    {
        return [
            'bsn_nummer.unique' => 'Dit BSN-nummer is al in gebruik.',
            'bsn_nummer.regex' => 'Het BSN-nummer moet uit 9 cijfers bestaan.',
            'postcode.regex' => 'Gebruik een geldige postcode, bijvoorbeeld 1234 AB.',
            'telefoonnummer.regex' => 'Gebruik alleen cijfers, spaties en + - ( ).',
        ];
    }
}
