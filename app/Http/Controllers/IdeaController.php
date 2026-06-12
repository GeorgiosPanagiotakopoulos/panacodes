<?php

namespace App\Http\Controllers;

use App\Enums\IdeaStatus;
use App\Http\Requests\IdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $ideas = $user
            ->ideas()
            ->when(
                in_array($request->status, IdeaStatus::values()),
                fn ($query) => $query->where('status', $request->status)
            )
            ->latest()
            ->get();

        return view('ideas.ideas', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts(Auth::user()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request)
    {
        $validated = $request->validated();

        $idea = Auth::user()->ideas()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'links' => $validated['links'] ?? [],
        ]);

        $steps = collect($request->input('steps', []))
            ->filter(fn ($step) => filled($step))
            ->map(fn ($step) => ['description' => $step])
            ->all();

        if ($steps !== []) {
            $idea->steps()->createMany($steps);
        }

        if ($request->hasFile('image')) {
            $idea->update([
                'image_path' => $request->file('image')->store('ideas', 'public'),
            ]);
        }

        return to_route('ideas.index')->with('success', 'Idea created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        return view('ideas.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        Gate::authorize('workWith', $idea);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        $data = collect($request->validated())
            ->except(['steps', 'image'])
            ->toArray();

        if ($request->hasFile('image')) {

            if ($idea->image_path) {
                Storage::disk('public')->delete($idea->image_path);
            }

            $data['image_path'] = $request->file('image')->store('ideas', 'public');
        }

        $idea->update($data);

        $steps = collect($request->input('steps', []))
            ->filter(fn ($step) => filled($step))
            ->map(fn ($step) => ['description' => $step])
            ->all();

        $idea->steps()->delete();

        if ($steps) {
            $idea->steps()->createMany($steps);
        }

        return to_route('ideas.index')
            ->with('success', 'Idea updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        $idea->delete();

        return to_route('ideas.index');
    }
}
