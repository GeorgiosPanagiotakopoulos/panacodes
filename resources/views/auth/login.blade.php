@props(['title' => 'Default Title'])
<x-layout title="Log In">
    <div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">Sign in to continue.</h2>
            <p class="mt-2 text-lg/8 text-gray-400">Welcome Back!</p>
        </div>
        <form action="/login" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            @csrf
            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />

            <button type="submit" class="mt-10 w-full rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">Log In</button>
            <p class="mt-5 text-sm/6 font-semibold text-zinc-400 transition ">
                Not registered yet?
                <a href="/register" class="hover:text-white">Sign up</a>
            </p>
        </form>
    </div>

</x-layout>