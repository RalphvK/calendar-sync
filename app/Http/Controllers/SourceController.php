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
            'title' => 'required|string|max:255', // Added title validation
            'type' => 'required|string',
            'ics_url' => 'required|url',
        ]);

        Auth::user()->sources()->create($request->only('title', 'type', 'ics_url')); // Added title

        return redirect()->route('sources.index')->with('success', 'Source created successfully.');
    }

    /**
     * Display the specified Source.
     *
     * @param Source $source
     * @return \Illuminate\View\View
     */
    public function view(Source $source)
    {
        return view('sources.view', compact('source'));
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
            'title' => 'required|string|max:255', // Added title validation
            'type' => 'required|string',
            'ics_url' => 'required|url',
        ]);

        $source->update($request->only('title', 'type', 'ics_url')); // Added title

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
