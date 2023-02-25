<?php
namespace App\Http\Controllers\Api;

use App\Models\Tags;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotesCollection;

class TagsAllNotesController extends Controller
{
    public function index(Request $request, Tags $tags): NotesCollection
    {
        $this->authorize('view', $tags);

        $search = $request->get('search', '');

        $allNotes = $tags
            ->allNotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new NotesCollection($allNotes);
    }

    public function store(Request $request, Tags $tags, Notes $notes): Response
    {
        $this->authorize('update', $tags);

        $tags->allNotes()->syncWithoutDetaching([$notes->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Tags $tags,
        Notes $notes
    ): Response {
        $this->authorize('update', $tags);

        $tags->allNotes()->detach($notes);

        return response()->noContent();
    }
}
