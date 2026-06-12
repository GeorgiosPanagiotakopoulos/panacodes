@props(['title' => 'Default Title'])
<x-layout title="Register">
    <div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">Register an account</h2>
        </div>
        <form action="/register" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            @csrf
            <x-form.field name="name" label="Name" />
            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />

            <div class="mt-6">
                <label class="flex gap-x-3 text-sm leading-6 text-zinc-300">
                    <input
                        type="checkbox"
                        name="privacy_policy"
                        value="1"
                        required
                        class="mt-1 h-4 w-4 rounded border-white/20 bg-white/5"
                    >

                    <span>
                        I have read and agree to the
                        <a href="/privacy" target="_blank" class="font-semibold text-white underline hover:text-zinc-300">
                            Privacy Policy
                        </a>.
                    </span>
                </label>

                @error('privacy_policy')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="mt-10 w-full rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">Sign Up</button>
            <p class="mt-5 text-sm/6 font-semibold text-zinc-400 transition ">
                Already have an account?
                <a href="/login" class="hover:text-white">Sign in</a>
            </p>
        </form>
    </div>

</x-layout>