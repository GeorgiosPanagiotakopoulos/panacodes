@props(['idea' => new App\Models\Idea()])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit idea' : 'Create idea' }}" >
    <form 
        x-data="{
            status: @js(old('status', $idea->status->value)),
            newLink: '',
            links: @js(old('links', $idea->links?->toArray() ?? [])),
            newStep: '',
            steps: @js(old('steps', $idea->steps->map(fn($step) => $step->description))),
            imageName: ''
        }" 
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="mx-auto mt-16 max-w-2xl sm:mt-20"
    >
        @csrf

        @if ($idea->exists)
            @method('PATCH')
        @endif
        
        <div class="space-y-6">
            <x-form.field 
                name="title"
                label="Title"
                placeholder="Enter an idea for your title"
                autofocus
                :value="$idea->title"
            />

            <div>
                <label for="status" class="label text-white">Status</label>

                <div class="mt-2.5 flex gap-x-3 justify-center">
                    @foreach (App\Enums\IdeaStatus::cases() as $status)
                        <button 
                            type="button"
                            @click="status = @js($status->value)"
                            class="px-4 py-2 rounded-lg font-medium border-2 border-white transition-all duration-200 whitespace-nowrap text-[10px] sm:text-base text-gray-900"
                            :class="status === @js($status->value) ? 'bg-white shadow-md' : 'bg-zinc-400'"
                        >
                            {{ $status->label() }}
                        </button>
                    @endforeach

                    <input
                        type="hidden"
                        name="status"
                        :value="status"
                        class="input"
                    >
                </div>

                @error('status')
                    <p class="error"> {{ $message }} </p>
                @enderror
            </div>

            <x-form.field 
                name="description"
                label="Description"
                type="textarea"
                placeholder="Describe your idea..."
                :value="$idea->description"
            />
        </div>

        @if ($idea->image_path)
            <div class="mt-10 rounded-xl overflow-hidden h-48 flex items-center justify-center">
                <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-full object-cover">
            </div>
            <div class="mt-5 flex justify-end">
                <button form="delete-image-form" class="px-4 py-2 rounded-lg font-medium transition-all duration-200 whitespace-nowrap text-sm sm:text-md text-gray-900 bg-red-500" > Remove Image </button>
            </div>
        @endif
                     

        <div class="space-y-2 mt-5">
            <label for="image" class="label text-white">Featured Image</label>

            <div class="mt-2 flex items-center gap-2">
                <label
                    for="image"
                    class="flex flex-1 cursor-pointer items-center rounded-lg border border-white/10 bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white"
                >
                    <span
                        x-text="imageName || 'Choose an image'"
                        class="text-zinc-300 truncate"
                    ></span>
                </label>
            </div>
  
            <input
                id="image"
                type="file"
                name="image"
                accept="image/*"
                class="hidden"
                @change="imageName = $event.target.files[0]?.name || ''"
                
            >
            @error('image')
                <p class="error"> {{ $message }} </p>
            @enderror
        </div>

        <div>
            <fieldset class="space-y-3 flex-col justify-center">
                <div class="label block text-sm/6 font-semibold text-white mt-5">Actionable Steps</div>

                <template x-for="(step, index) in steps" :key="step">
                    <div class="flex gap-x-2 items-center">
                        <input name="steps[]" x-model="step" class="input text-white" readonly>

                        <button
                            type="button"
                            aria-label="Remove step"
                            @click="steps.splice(index, 1);" 
                            class="text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </template>    

                <div class="flex gap-x-2 items-center">
                    <input
                        x-model="newStep"
                        id="new-step"
                        placeholder="What needs to be done?"
                        class="input block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white mt-2.5"
                        spellcheck="false"
                    >

                    <button
                        type="button"
                        @click="steps.push(newStep.trim()); newStep = '';"
                        :disabled="newStep.trim().length === 0"
                        aria-label="Add a new Step"
                        class="text-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                    </button>
                </div>
            </fieldset>
        </div>
        
        <div class="">
            <fieldset class="space-y-3 flex-col justify-center">
                <div class="label block text-sm/6 font-semibold text-white mt-5">Links</div>

                <template x-for="(link, index) in links" :key="link">
                    <div class="flex gap-x-2 items-center">
                        <input name="links[]" x-model="link" class="input text-white">

                        <button
                            type="button"
                            aria-label="Remove link"
                            @click="links.splice(index, 1);" 
                            class="text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </template>    

                <div class="flex gap-x-2 items-center">
                    <input
                        x-model="newLink"
                        type="text"
                        inputmode="url"
                        id="new-link"
                        placeholder="http://example.com"
                        autocomplete="url"
                        class="input block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white mt-2.5"
                        spellcheck="false"
                    >

                    <button
                        type="button"
                        @click="const candidate = newLink.trim(); if (!candidate) return; const normalized = /^https?:\/\//i.test(candidate) ? candidate : `https://${candidate}`; links.push(normalized); newLink = '';"
                        :disabled="newLink.trim().length === 0"
                        aria-label="Add a new link"
                        class="text-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                    </button>
                </div>
            </fieldset>
        </div>

        <div class="flex justify-end gap-x-5 mt-10">
            <button type="button" @click="$dispatch('close-modal')" class="px-4 py-2 rounded-lg font-medium transition-all duration-200 whitespace-nowrap text-sm sm:text-md text-gray-900 bg-red-500">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded-lg font-medium transition-all duration-200 whitespace-nowrap text-sm sm:text-md text-gray-900 bg-green-500">{{ $idea->exists ? 'Update' : 'Create' }}</button>
        </div>

    </form>
    @if ($idea->image_path)
        <form method="POST" action="{{ route('idea.image.destroy', $idea) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>