<?php

namespace App\Http\Controllers\Api;

use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TagsResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsCollection;
use App\Http\Requests\TagsStoreRequest;
use App\Http\Requests\TagsUpdateRequest;

class TagsController extends Controller
{
    public function index(Request $request): TagsCollection
    {
        $this->authorize('view-any', Tags::class);

        $search = $request->get('search', '');

        $allTags = Tags::search($search)
            ->latest()
            ->paginate();

        return new TagsCollection($allTags);
    }

    public function store(TagsStoreRequest $request): TagsResource
    {
        $this->authorize('create', Tags::class);

        $validated = $request->validated();

        $tags = Tags::create($validated);

        return new TagsResource($tags);
    }

    public function show(Request $request, Tags $tags): TagsResource
    {
        $this->authorize('view', $tags);

        return new TagsResource($tags);
    }

    public function update(TagsUpdateRequest $request, Tags $tags): TagsResource
    {
        $this->authorize('update', $tags);

        $validated = $request->validated();

        $tags->update($validated);

        return new TagsResource($tags);
    }

    public function destroy(Request $request, Tags $tags): Response
    {
        $this->authorize('delete', $tags);

        $tags->delete();

        return response()->noContent();
    }
}
