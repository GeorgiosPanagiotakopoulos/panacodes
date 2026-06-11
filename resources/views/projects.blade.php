@props(['title' => 'Default Title'])
<x-layout title="Projects">
    <section class="space-y-6">

        <div class="space-y-2">
            <h1 class="text-4xl text-white font-bold tracking-tight">My Projects</h1>
            <p class="text-lg text-white">A collection of things I’ve built while learning, breaking things, fixing them, and shipping real functionality.</p>
        </div>

        <div class="grid grid-cols-1 pt-4 gap-y-10">
            
            <a
                href="/ideas"
                class="block rounded-xl border border-white/20 p-10 transition hover:border-white/40 hover:bg-white/5"
            >
                <h2 class="text-xl font-semibold text-white">
                    Ideas
                </h2>

                <p class="mt-2 text-gray-300">
                    Inspired by the Laracasts Laravel From Scratch 2026 series.
                </p>
            </a>
        </div>

    </section>
</x-layout>

