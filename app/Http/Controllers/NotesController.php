<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notes;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\NotesStoreRequest;
use App\Http\Requests\NotesUpdateRequest;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Notes::class);

        $search = $request->get('search', '');

        $allNotes = Notes::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.all_notes.index', compact('allNotes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Notes::class);

        $users = User::pluck('name', 'id');

        return view('app.all_notes.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotesStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Notes::class);

        $validated = $request->validated();

        $notes = Notes::create($validated);

        return redirect()
            ->route('all-notes.edit', $notes)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Notes $notes): View
    {
        $this->authorize('view', $notes);

        return view('app.all_notes.show', compact('notes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Notes $notes): View
    {
        $this->authorize('update', $notes);

        $users = User::pluck('name', 'id');

        return view('app.all_notes.edit', compact('notes', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        NotesUpdateRequest $request,
        Notes $notes
    ): RedirectResponse {
        $this->authorize('update', $notes);

        $validated = $request->validated();

        $notes->update($validated);

        return redirect()
            ->route('all-notes.edit', $notes)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Notes $notes): RedirectResponse
    {
        $this->authorize('delete', $notes);

        $notes->delete();

        return redirect()
            ->route('all-notes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
