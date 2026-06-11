@props(['title' => 'Default Title'])
<x-layout title="Ideas">
    <div class="text-white w-screen mt-10 px-25">
        <h1 class="text-3xl font-bold">Ideas</h1>
        <p class="text-sm mt-2">
            A simple idea-sharing application built with Laravel as part of my learning journey through Laracasts. 
            The project allows users to submit, view, and manage short project ideas, demonstrating core CRUD functionality, 
            authentication, and clean MVC architecture. It focuses on practical Laravel fundamentals such as routing, controllers, 
            Eloquent models, form validation, and basic UI structure. This project helped reinforce my understanding of building 
            structured, maintainable web applications using Laravel best practices. https://laracasts.com/series/laravel-from-scratch-2026
        </p>
     
        <button 
            x-data
            @click="$dispatch('open-modal', 'create-idea')"
            type="button"
            class="mt-10 cursor-pointer h-32 text-left border border-border rounded-lg p-4 md:text-sm text-center"
        >
            <p>Got an idea?</br> Create now</p>
        </button>

        <div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-x-5 gap-y-5">

            <a href="{{ route('ideas.index') }}"
                class="px-4 py-2 rounded-lg font-medium border-2 transition-all duration-200 whitespace-nowrap text-sm  sm:text-md
                {{ request('status')
                ? 'bg-zinc-400 text-gray-900 border-white'
                : 'bg-white text-gray-900 border-white shadow-md' }}">
                All <span class="text-sm pl-3">{{ $statusCounts['all'] ?? array_sum($statusCounts) }}</span>
            </a>
            @foreach (App\Enums\IdeaStatus::cases() as $status)
                <a href="{{ route('ideas.index', ['status' => $status->value]) }}"
                    class="px-4 py-2 rounded-lg font-medium border-2 transition-all duration-200 whitespace-nowrap text-sm sm:text-md
                    {{ request('status') === $status->value
                    ? 'bg-white text-gray-900 border-white shadow-md'
                    : 'bg-zinc-400 text-gray-900 border-white' }}">
                    {{ $status->label() }} <span class="text-sm pl-3">{{ $statusCounts->get($status->value, 0) }}</span>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($ideas as $idea)
                    <x-card href="{{ route('idea.show', $idea) }}">

                        <div class="mb-4 -mx-4 -mt-4 rounded-xl overflow-hidden bg-zinc-800/80 border border-white/10 h-48 flex items-center justify-center text-zinc-300">
                            @if ($idea->image_path)
                                <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs uppercase tracking-[0.35em] text-zinc-400">No image</span>
                            @endif
                        </div>

                        <h3 class="text-lg">{{ $idea->title }}</h3>

                        <div class="mt-1">
                            <x-idea.status-label :status="$idea->status">
                                {{ $idea->status->label() }}
                            </x-idea.status-label>
                        </div>

                        <div class="mt-5 line-clamp-3">
                            {{ $idea->description }}
                        </div>

                        <div class="mt-4">
                            {{ $idea->created_at->diffForHumans() }}
                        </div>
                    </x-card>
                @empty
                    <h1>No ideas at this time.</h1>
                @endforelse
            </div>
        </div>

        <x-idea.idea-modal/>
    </div>
</x-layout>