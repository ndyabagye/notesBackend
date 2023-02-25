<?php

namespace App\Http\Controllers\Api;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotesResource;
use App\Http\Resources\NotesCollection;
use App\Http\Requests\NotesStoreRequest;
use App\Http\Requests\NotesUpdateRequest;

class NotesController extends Controller
{
    public function index(Request $request): NotesCollection
    {
        $this->authorize('view-any', Notes::class);

        $search = $request->get('search', '');

        $allNotes = Notes::search($search)
            ->latest()
            ->paginate();

        return new NotesCollection($allNotes);
    }

    public function store(NotesStoreRequest $request): NotesResource
    {
        $this->authorize('create', Notes::class);

        $validated = $request->validated();

        $notes = Notes::create($validated);

        return new NotesResource($notes);
    }

    public function show(Request $request, Notes $notes): NotesResource
    {
        $this->authorize('view', $notes);

        return new NotesResource($notes);
    }

    public function update(
        NotesUpdateRequest $request,
        Notes $notes
    ): NotesResource {
        $this->authorize('update', $notes);

        $validated = $request->validated();

        $notes->update($validated);

        return new NotesResource($notes);
    }

    public function destroy(Request $request, Notes $notes): Response
    {
        $this->authorize('delete', $notes);

        $notes->delete();

        return response()->noContent();
    }
}
