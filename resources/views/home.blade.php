@extends('layouts.app')

@section('content')
<div class="mb-10">
    <h1 class="text-2xl sm:text-3xl font-bold text-[#990000] mb-1">Discover Davao's Best Carinderias</h1>
    <p class="text-sm text-neutral-600 mb-6">Explore neighborhood favorites, check business permits, and share honest reviews across Davao City.</p>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-neutral-300 rounded-sm p-4">
            <p class="text-xs font-bold uppercase tracking-wide text-neutral-500">Listed Eateries</p>
            <p class="text-3xl font-bold text-[#990000] mt-1">{{ $eateryCount }}</p>
        </div>
        <div class="bg-white border border-neutral-300 rounded-sm p-4">
            <p class="text-xs font-bold uppercase tracking-wide text-neutral-500">Districts Covered</p>
            <p class="text-3xl font-bold text-[#990000] mt-1">{{ $districtCount }}</p>
        </div>
        <div class="bg-white border border-neutral-300 rounded-sm p-4">
            <p class="text-xs font-bold uppercase tracking-wide text-neutral-500">Resident Reviews</p>
            <p class="text-3xl font-bold text-[#990000] mt-1">{{ $reviewCount }}</p>
        </div>
    </div>
</div>

<section>
    <div class="flex items-center justify-between pb-2 mb-4 border-b border-neutral-300">
        <h2 class="text-xl font-bold text-neutral-900">Top Rated</h2>
        <a href="{{ route('eateries.index') }}" class="text-sm font-medium text-[#990000] hover:underline">View all eateries &rarr;</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($topEateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @endforeach
    </div>
</section>
@endsection