@props(['name', 'title'])

<div 
    x-data="{ show: false, name: @js($name) }"
    x-show="show"
    @open-modal.window="if($event.detail === name) show = true"
    @close-modal="show = false"
    @keydown.escape.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-md bg-gray-800/50"
    x-transition:enter="ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-4 -translate-x-4"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 -translate-y-4 -translate-x-4"
    style="display: none"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-{{ $name }}-title"
    :aria-hidden="!show"
    tabindex="-1"
>
    <x-card @click.away="show = false" class="shadow-xl max-w-[calc(100vw-20px)] sm:max-w-xl md:max-w-2xl lg:max-w-3xl w-full max-h-[80dvh] overflow-auto">
        <div class="flex justify-between px-8 items-center">
            <h2 id="modal-{{ $name }}-title" class="text-xl font-bold text-white">{{ $title }}</h2>

            <button @click="show = false" aria-label="Close modal" class="text-white">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
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
        <div>
            {{$slot}}
        </div>

    </x-card>
</div>