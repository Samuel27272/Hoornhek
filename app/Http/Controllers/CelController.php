<?php

namespace App\Http\Controllers;

use App\Models\Cel;
use Illuminate\Database\QueryException;
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
        try {
            $data = $request->validate([
                'cel_nummer' => 'required|string|max:20|regex:/^[A-Za-z0-9\-]+$/',
                'capaciteit' => 'required|integer|min:1|max:999',
                'status' => 'required|in:beschikbaar,bezet,buiten_gebruik',
                'opmerkingen' => 'nullable|string|max:2000',
            ]);

            Cel::create($data);

            return redirect()->route('cellen.index')->with('success', 'Cel aangemaakt.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
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
        try {
            $data = $request->validate([
                'cel_nummer' => 'required|string|max:20|regex:/^[A-Za-z0-9\-]+$/',
                'capaciteit' => 'required|integer|min:1|max:999',
                'status' => 'required|in:beschikbaar,bezet,buiten_gebruik',
                'opmerkingen' => 'nullable|string|max:2000',
            ]);

            $cellen->update($data);

            return redirect()->route('cellen.index')->with('success', 'Wijzigingen opgeslagen.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->databaseError($request);
        }
    }

    /** Remove the specified resource from storage. */
    public function destroy(Cel $cellen)
    {
        $cellen->delete();

        return redirect()->route('cellen.index')->with('success', 'Cel verwijderd.');
    }
}
