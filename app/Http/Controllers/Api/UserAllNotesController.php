<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotesResource;
use App\Http\Resources\NotesCollection;

class UserAllNotesController extends Controller
{
    public function index(Request $request, User $user): NotesCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $allNotes = $user
            ->allNotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new NotesCollection($allNotes);
    }

    public function store(Request $request, User $user): NotesResource
    {
        $this->authorize('create', Notes::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'color' => ['required'],
        ]);

        $notes = $user->allNotes()->create($validated);

        return new NotesResource($notes);
    }
}
