@props(['label' => false, 'name', 'type' => 'text', 'value' =>''])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm/6 font-semibold text-white mt-5">{{ $label }}</label>
    @endif

    @if ($type === 'textarea')
        <textarea 
            id="{{ $name }}" 
            type="{{ $type }}" 
            name="{{ $name }}" 
            value="{{ old($name) }}" 
            class="textarea block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white mt-2.5"
        >{{ old($name, $value) }} </textarea>
    @else
        <input 
            id="{{ $name }}" 
            type="{{ $type }}" 
            name="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            class="input block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-white mt-2.5"
        />
    @endif
    @error($name)
        <p class="error mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>