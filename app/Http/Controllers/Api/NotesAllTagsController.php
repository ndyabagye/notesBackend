<?php
namespace App\Http\Controllers\Api;

use App\Models\Tags;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsCollection;

class NotesAllTagsController extends Controller
{
    public function index(Request $request, Notes $notes): TagsCollection
    {
        $this->authorize('view', $notes);

        $search = $request->get('search', '');

        $allTags = $notes
            ->allTags()
            ->search($search)
            ->latest()
            ->paginate();

        return new TagsCollection($allTags);
    }

    public function store(Request $request, Notes $notes, Tags $tags): Response
    {
        $this->authorize('update', $notes);

        $notes->allTags()->syncWithoutDetaching([$tags->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Notes $notes,
        Tags $tags
    ): Response {
        $this->authorize('update', $notes);

        $notes->allTags()->detach($tags);

        return response()->noContent();
    }
}
