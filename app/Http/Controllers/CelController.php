<?php

namespace App\Http\Controllers;

use App\Models\Cel;
use Illuminate\Http\Request;

class CelController extends Controller
{
    /** Display a listing of the resource. */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Cel::query();
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('cel_nummer', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");
            });
        }

        $cellen = $query->orderBy('cel_nummer')->paginate(15)->withQueryString();

        return view('cellen.index', compact('cellen', 'q'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        $cel = new Cel;

        return view('cellen.create', compact('cel'));
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cel_nummer' => 'required|string',
            'capaciteit' => 'required|integer|min:1',
            'status' => 'required|in:beschikbaar,bezet,buiten_gebruik',
            'opmerkingen' => 'nullable|string',
        ]);

        Cel::create($data);

        return redirect()->route('cellen.index')->with('success', 'Cel aangemaakt.');
    }

    /** Display the specified resource. */
    public function show(Cel $cellen)
    {
        $cellen->load('gedetineerden');

        return view('cellen.show', ['cel' => $cellen]);
    }

    /** Show the form for editing the specified resource. */
    public function edit(Cel $cellen)
    {
        return view('cellen.edit', ['cel' => $cellen]);
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, Cel $cellen)
    {
        $data = $request->validate([
            'cel_nummer' => 'required|string',
            'capaciteit' => 'required|integer|min:1',
            'status' => 'required|in:beschikbaar,bezet,buiten_gebruik',
            'opmerkingen' => 'nullable|string',
        ]);

        $cellen->update($data);

        return redirect()->route('cellen.index')->with('success', 'Wijzigingen opgeslagen.');
    }

    /** Remove the specified resource from storage. */
    public function destroy(Cel $cellen)
    {
        $cellen->delete();

        return redirect()->route('cellen.index')->with('success', 'Cel verwijderd.');
    }
}
