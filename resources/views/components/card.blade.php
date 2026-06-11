@props(['is' => 'a'])

<{{$is}} {{$attributes(['class' => 'border border-border rounded-lg p-4 md:text-sm text-center']) }}>
    {{ $slot }}
</{{$is}}>