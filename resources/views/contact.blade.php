@props(['title' => 'Default Title'])
<x-layout title="Contact">
    <div>
        <div class="mx-auto max-w-2xl text-center mt-10">
            <h2 class="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">Contact me</h2>
            <p class="mt-2 text-lg/8 text-gray-400">Leave your details below and I’ll get back to you as soon as possible.</p>
        </div>
        <form action="{{ route('contact.store') }}" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            @csrf

            <div>
                <label for="name" class="block text-sm/6 font-semibold text-white">Name</label>
                <div class="mt-2.5">
                <input id="name" type="text" name="name" autocomplete="name" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white" />
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="email" class="block text-sm/6 font-semibold text-white mt-5">Email</label>
                <div class="mt-2.5">
                <input id="email" type="email" name="email" autocomplete="email" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white" />
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="phone-number" class="block text-sm/6 font-semibold text-white mt-5">Phone number</label>
                <div class="mt-2.5">
                <div class="flex rounded-md bg-white/5 outline-1 -outline-offset-1 outline-white/10 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-white">
                    <input id="phone-number" type="text" name="phone_number" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" />
                </div>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="message" class="block text-sm/6 font-semibold text-white mt-5">Message</label>
                <div class="mt-2.5">
                <textarea id="message" name="message" rows="4" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white"></textarea>
                </div>
            </div>

            <div class="mt-10">
            <button type="submit" class="w-full rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">Let's talk</button>
            </div>
        </form>
    </div>

</x-layout>