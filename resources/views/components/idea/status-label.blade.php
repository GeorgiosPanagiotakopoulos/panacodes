@props(['status' => 'pending'])

@php
    $statusValue = $status instanceof \BackedEnum ? $status->value : (string) $status;
    $classes = 'inline-block rounded-full border px-2 py-1 text-xs font-medium';

    if ($statusValue === 'pending') {
        $classes .= ' bg-yellow-500/10 text-yellow-500 border-yellow-500/20';
    }

    if ($statusValue === 'in_progress') {
        $classes .= ' bg-blue-500/10 text-blue-500 border-blue-500/20';
    }

    if ($statusValue === 'completed') {
        $classes .= ' bg-green-500/10 text-green-500 border-green-500/20';
    }
@endphp

<span {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</span>