@extends('layouts.app')

@section('content')
<div class="pb-3 mb-6 border-b border-neutral-300">
    <h1 class="text-2xl sm:text-3xl font-bold text-[#990000]">{{ $district->name }}</h1>
    <p class="text-sm font-medium text-neutral-600 mt-1">
        {{ $reviewsCount }} {{ $reviewsCount === 1 ? 'review' : 'reviews' }} in {{ $district->name }}
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach ($eateries as $eatery)
        <x-eatery-card :eatery="$eatery" />
    @endforeach
</div>
@endsection