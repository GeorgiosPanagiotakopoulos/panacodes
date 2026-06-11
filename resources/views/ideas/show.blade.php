@props(['title' => 'Default Title'])
<x-layout :title="$idea->title">
    <div class="py-8 w-2xl px-7 bg-gray-800">

        <div class="flex justify-between text-white">
            <a href="{{ route('ideas.index') }}" class="flex items-center gap-x-2 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M19 12H5" />
                    <path d="M12 19l-7-7 7-7" />
                </svg>
                <div class="hidden sm:block">Back to Ideas</div>
            </a>

            <div class="gap-x-3 flex items-center">
                <button 
                    class="flex gap-2 px-4 py-2 rounded-lg font-medium transition-all duration-200 whitespace-nowrap text-sm sm:text-md text-gray-900 bg-green-500"
                    x-data
                    @click="$dispatch('open-modal', 'edit-idea')"
                    type="button"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14 3h7v7" />
                        <path d="M10 14L21 3" />
                        <path d="M21 14v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7" />
                    </svg>
                    Edit Idea
                </button>

                <form method="POST" action="{{ route('idea.destroy', $idea) }}">
                    @csrf
                    @method('DELETE')

                    <button @click="$dispatch('close-modal')" class="button flex gap-2 px-4 py-2 rounded-lg font-medium transition-all duration-200 whitespace-nowrap text-sm sm:text-md text-gray-900 bg-red-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-8 space-y-6 text-white">

            @if ($idea->image_path)
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class="w-full h-48 object-contain">
                </div>
            @endif
            <h1 class="font-bold text-4xl"> {{ $idea->title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-idea.status-label :status="$idea->status">
                    {{ $idea->status->label() }}
                </x-idea.status-label>

                <div class="text-sm"> {{ $idea->created_at->diffForHumans() }}</div>
            </div>

            @if ($idea->description)
                <div class="mt-6">{{ $idea->description }}</div>
            @endif

            @if ($idea->steps->count())
                <div class="mt-3 space-y-3">
                    <h3 class="font-bold text-xl mt-6">Actionable Steps</h3>

                    <div>
                        @foreach ($idea->steps as $step)
                            <x-card class="font-medium flex gap-x-3 items-center">
                                <form method="POST" action="{{ route('step.update', $step) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="flex items-center gap-x-3">
                                        <button
                                            type="submit"
                                            role="checkbox"
                                            class="flex items-center justify-center rounded-lg w-4 h-4 text-white {{ $step->completed ? 'bg-green-500' : 'bg-white' }}">&check;
                                        </button>
                                        <span class="{{ $step->completed ? 'line-through text-muted-foreground' : ''}}">{{ $step->description }}</span>
                                    </div> 
                                </form>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($idea->links->count())
                <div class="mt-3 space-y-3">
                    <h3 class="font-bold text-xl mt-6">Links</h3>

                    <div>
                        @foreach ($idea->links as $link)
                            <x-card :href="$link" class="font-medium flex gap-x-3 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">

                                    <path d="M14 3h7v7" />
                                    <path d="M10 14L21 3" />
                                    <path d="M21 14v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7" />
                                </svg>
                                {{ $link }}
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <x-idea.idea-modal :idea="$idea" />
    </div>
</x-layout>