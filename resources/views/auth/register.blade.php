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

            <button type="submit" class="mt-10 block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign Up</button>

        </form>
    </div>

</x-layout>