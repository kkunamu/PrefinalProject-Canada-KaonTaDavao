@props(['eatery'])

@php
    $pesoMap = [
        'budget' => '₱',
        'mid' => '₱₱',
        'splurge' => '₱₱₱',
    ];
    $peso = $pesoMap[$eatery->price_range] ?? '₱';
    $reviewCount = $eatery->reviews_count ?? 0;
    $avgRating = $eatery->reviews_avg_rating;
@endphp

<article class="bg-white border border-neutral-300 rounded-sm p-5 flex flex-col justify-between hover:border-neutral-400 transition-colors">
    <div>
        <div class="flex items-start justify-between gap-2 pb-2.5 mb-2.5 border-b border-neutral-200">
            <div>
                <h3 class="text-lg font-bold text-[#990000] leading-snug">
                    <a href="{{ route('eateries.show', $eatery) }}" class="hover:underline">
                        {{ $eatery->name }}
                    </a>
                </h3>
                <p class="text-xs text-neutral-600 mt-0.5">
                    in
                    <a href="{{ route('districts.show', $eatery->district) }}" class="text-[#990000] hover:underline font-semibold">
                        {{ $eatery->district->name }}
                    </a>
                    &middot; <span class="font-bold text-neutral-800">{{ $peso }}</span>
                </p>
            </div>

            @unless ($eatery->is_open)
                <span class="shrink-0 bg-red-100 border border-red-300 text-[#990000] text-xs font-bold px-2 py-0.5 rounded-sm uppercase">
                    Closed
                </span>
            @endunless
        </div>

        @if ($eatery->specialty)
            <p class="text-sm text-neutral-700 mb-3">
                <span class="font-semibold text-neutral-800">Specialty:</span> {{ $eatery->specialty }}
            </p>
        @endif

        <div class="flex flex-wrap gap-1.5 mb-4">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                   class="text-xs bg-neutral-100 text-neutral-700 border border-neutral-300 px-2 py-0.5 rounded-sm hover:bg-[#990000] hover:text-white hover:border-[#990000] transition-colors">
                    {{ $feature->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="pt-2.5 border-t border-neutral-200 text-xs flex items-center justify-between text-neutral-600">
        @if ($reviewCount > 0)
            <div class="flex items-center gap-1.5">
                <x-rating :value="$avgRating" />
                <span class="font-bold text-neutral-800">{{ number_format($avgRating, 1) }}</span>
                <span>({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
            </div>
        @else
            <span class="text-neutral-400 italic">No reviews yet</span>
        @endif
    </div>
</article>