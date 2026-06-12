@props(['title' => 'Default Title'])
<x-layout title="Edit Your Profile">
    <div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">Edit Your Profile</h2>
        </div>
        <form action="/profile" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            @csrf
            @method('PATCH')
            <x-form.field name="name" label="Name" :value="$user->name" />
            <x-form.field name="email" label="Email" type="email" :value="$user->email"/>
            <x-form.field name="password" label="New Password" type="password" />

            <button type="submit" class="mt-10 w-full rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">Update Account</button>
        </form>
    </div>

</x-layout>