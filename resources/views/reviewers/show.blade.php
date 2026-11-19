@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="pb-3 mb-6 border-b border-neutral-300">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#990000]">{{ $user->name }}</h1>
        <p class="text-sm font-medium text-neutral-600 mt-1">
            {{ $reviews->count() }} {{ $reviews->count() === 1 ? 'review' : 'reviews' }} written
        </p>
    </div>

    <div class="space-y-4">
        @forelse ($reviews as $review)
            <article class="bg-white border border-neutral-300 rounded-sm p-4">
                <div class="flex flex-wrap items-center justify-between gap-2 pb-2 mb-2 border-b border-neutral-200">
                    <a href="{{ route('eateries.show', $review->eatery) }}" class="font-bold text-[#990000] hover:underline">
                        {{ $review->eatery->name }}
                    </a>
                    <x-rating :value="$review->rating" />
                </div>
                <p class="text-sm text-neutral-800">{{ $review->body }}</p>
            </article>
        @empty
            <p class="text-sm text-neutral-500">No reviews written yet.</p>
        @endforelse
    </div>
</div>
@endsection