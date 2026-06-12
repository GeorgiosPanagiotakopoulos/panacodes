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

            <button type="submit" class="mt-10 w-full rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">Sign Up</button>
            <p class="mt-5 text-sm/6 font-semibold text-zinc-400 transition ">
                Already have an account?
                <a href="/login" class="hover:text-white">Sign in</a>
            </p>
        </form>
    </div>

</x-layout>