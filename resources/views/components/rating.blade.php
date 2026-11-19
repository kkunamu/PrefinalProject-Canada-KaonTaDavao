@props(['value' => 0])

@php
    $rounded = (int) round($value);
@endphp

<span class="inline-flex items-center text-[#990000]" aria-label="{{ number_format($value, 1) }} out of 5 stars">
    @for ($i = 1; $i <= 5; $i++)
        <span>{{ $i <= $rounded ? '★' : '☆' }}</span>
    @endfor
</span>