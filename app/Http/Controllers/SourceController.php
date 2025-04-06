<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SourceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the user's sources.
     */
    public function index()
    {
        $sources = Auth::user()->sources;
        return view('sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new source.
     */
    public function create()
    {
        // check if user is authorized to create a source
        $this->authorize('create', Source::class);
        return view('sources.create');
    }

    /**
     * Store a newly created source in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Source::class);
        
        $request->validate([
            'type' => 'required|string',
            'ics_url' => 'required|url',
        ]);

        Auth::user()->sources()->create($request->only('type', 'ics_url'));

        return redirect()->route('sources.index')->with('success', 'Source created successfully.');
    }

    /**
     * Show the form for editing the specified source.
     */
    public function edit(Source $source)
    {
        $this->authorize('update', $source);
        return view('sources.edit', compact('source'));
    }

    /**
     * Update the specified source in storage.
     */
    public function update(Request $request, Source $source)
    {
        $this->authorize('update', $source);

        $request->validate([
            'type' => 'required|string',
            'ics_url' => 'required|url',
        ]);

        $source->update($request->only('type', 'ics_url'));

        return redirect()->route('sources.index')->with('success', 'Source updated successfully.');
    }

    /**
     * Remove the specified source from storage.
     */
    public function destroy(Source $source)
    {
        $this->authorize('delete', $source);
        $source->delete();

        return redirect()->route('sources.index')->with('success', 'Source deleted successfully.');
    }
}
