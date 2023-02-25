<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TagsStoreRequest;
use App\Http\Requests\TagsUpdateRequest;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Tags::class);

        $search = $request->get('search', '');

        $allTags = Tags::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.all_tags.index', compact('allTags', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Tags::class);

        return view('app.all_tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagsStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Tags::class);

        $validated = $request->validated();

        $tags = Tags::create($validated);

        return redirect()
            ->route('all-tags.edit', $tags)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Tags $tags): View
    {
        $this->authorize('view', $tags);

        return view('app.all_tags.show', compact('tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Tags $tags): View
    {
        $this->authorize('update', $tags);

        return view('app.all_tags.edit', compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TagsUpdateRequest $request,
        Tags $tags
    ): RedirectResponse {
        $this->authorize('update', $tags);

        $validated = $request->validated();

        $tags->update($validated);

        return redirect()
            ->route('all-tags.edit', $tags)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Tags $tags): RedirectResponse
    {
        $this->authorize('delete', $tags);

        $tags->delete();

        return redirect()
            ->route('all-tags.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
