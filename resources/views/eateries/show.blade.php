@extends('layouts.app')

@section('content')
@php
    $pesoMap = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
    $peso = $pesoMap[$eatery->price_range] ?? '₱';
    $isExpired = $eatery->permit && $eatery->permit->expires_on->lt(today());
@endphp

<div class="max-w-4xl mx-auto space-y-6">
    <!-- AO3 Work Header & Meta Box -->
    <div class="bg-white border border-neutral-300 rounded-sm p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 pb-4 mb-4 border-b border-neutral-200">
            <div>
                <div class="flex items-center gap-2.5 mb-1">
                    <h1 class="text-2xl sm:text-3xl font-bold text-neutral-900">{{ $eatery->name }}</h1>
                    @unless ($eatery->is_open)
                        <span class="bg-red-100 border border-red-300 text-[#990000] text-xs font-bold px-2.5 py-0.5 rounded-sm uppercase">Closed</span>
                    @endunless
                </div>
                <p class="text-sm text-neutral-600">
                    District:
                    <a href="{{ route('districts.show', $eatery->district) }}" class="text-[#990000] font-semibold hover:underline">
                        {{ $eatery->district->name }}
                    </a>
                    &middot; Price Range: <span class="font-bold text-neutral-800">{{ $peso }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('eateries.edit', $eatery) }}" class="px-3.5 py-1.5 text-xs font-semibold border border-neutral-300 bg-neutral-100 rounded-sm text-neutral-700 hover:bg-neutral-200">
                    Edit
                </a>
                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3.5 py-1.5 text-xs font-semibold bg-[#990000] text-white rounded-sm hover:bg-[#770000]">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- AO3 Meta Dl Box -->
        <dl class="bg-neutral-50 border border-neutral-200 rounded-sm p-4 text-sm grid grid-cols-1 sm:grid-cols-4 gap-y-2.5 gap-x-4 mb-5">
            <dt class="font-bold text-neutral-700">Address:</dt>
            <dd class="sm:col-span-3 text-neutral-800">{{ $eatery->address }}</dd>

            @if ($eatery->specialty)
                <dt class="font-bold text-neutral-700">Specialty:</dt>
                <dd class="sm:col-span-3 text-neutral-800">{{ $eatery->specialty }}</dd>
            @endif

            <dt class="font-bold text-neutral-700">Features:</dt>
            <dd class="sm:col-span-3 flex flex-wrap gap-1.5">
                @foreach ($eatery->features as $feature)
                    <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                       class="text-xs bg-white text-neutral-700 border border-neutral-300 px-2 py-0.5 rounded-sm hover:bg-[#990000] hover:text-white hover:border-[#990000]">
                        {{ $feature->name }}
                    </a>
                @endforeach
            </dd>
        </dl>

        @if ($eatery->permit)
            <div class="rounded-sm border border-neutral-300 bg-neutral-100 p-3.5 text-sm">
                <span class="font-bold text-neutral-800">Business Permit:</span>
                <span class="font-mono font-semibold text-neutral-900 ml-1">{{ $eatery->permit->permit_no }}</span>
                &middot; Expires on: <span class="font-semibold">{{ $eatery->permit->expires_on->format('M d, Y') }}</span>
                @if ($isExpired)
                    <span class="ml-2 font-bold text-red-600">Permit expired</span>
                @endif
            </div>
        @endif
    </div>

    <!-- Menu & Dishes -->
    <section class="bg-white border border-neutral-300 rounded-sm p-6 sm:p-8">
        <h2 class="text-lg font-bold text-neutral-900 pb-2 mb-4 border-b border-neutral-200">Menu &amp; Dishes</h2>
        @if ($eatery->dishes->isEmpty())
            <p class="text-sm text-neutral-500">No dishes listed yet.</p>
        @else
            <ul class="divide-y divide-neutral-200">
                @foreach ($eatery->dishes as $dish)
                    <li class="py-2.5 flex items-center justify-between gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-neutral-800">{{ $dish->name }}</span>
                            @if ($dish->is_bestseller)
                                <span class="text-xs font-bold bg-red-50 border border-red-200 text-[#990000] px-2 py-0.5 rounded-sm">Bestseller</span>
                            @endif
                        </div>
                        <span class="font-mono font-semibold text-neutral-900">₱{{ number_format($dish->price, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <!-- Reviews Section -->
    <section class="bg-white border border-neutral-300 rounded-sm p-6 sm:p-8">
        <h2 class="text-lg font-bold text-neutral-900 pb-2 mb-4 border-b border-neutral-200">Reviews ({{ $eatery->reviews->count() }})</h2>

        @if ($eatery->is_open)
            <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="mb-8 pb-6 border-b border-neutral-200 space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="rounded-sm border border-red-300 bg-red-50 p-3 text-sm text-[#990000]">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="user_id" class="block text-sm font-bold text-neutral-800 mb-1">Reviewer</label>
                        <select id="user_id" name="user_id" class="w-full bg-white border border-neutral-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-[#990000]">
                            <option value="">Select reviewer</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="rating" class="block text-sm font-bold text-neutral-800 mb-1">Rating (1–5)</label>
                        <select id="rating" name="rating" class="w-full bg-white border border-neutral-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-[#990000]">
                            <option value="">Select rating</option>
                            @for ($r = 5; $r >= 1; $r--)
                                <option value="{{ $r }}" @selected(old('rating') == $r)>{{ $r }} {{ $r === 1 ? 'Star' : 'Stars' }}</option>
                            @endfor
                        </select>
                        @error('rating') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="body" class="block text-sm font-bold text-neutral-800 mb-1">Your Review</label>
                    <textarea id="body" name="body" rows="3" placeholder="Share your experience..."
                              class="w-full bg-white border border-neutral-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-[#990000]">{{ old('body') }}</textarea>
                    @error('body') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-[#990000] text-white text-sm font-bold px-5 py-2 rounded-sm hover:bg-[#770000]">
                    Post Review
                </button>
            </form>
        @else
            <div class="mb-8 rounded-sm border border-neutral-300 bg-neutral-100 p-4 text-sm font-medium text-neutral-700">
                This eatery is closed. Reviews are paused.
            </div>
        @endif

        <div class="space-y-4">
            @forelse ($eatery->reviews as $review)
                <div class="border border-neutral-200 bg-neutral-50 rounded-sm p-4 flex items-start justify-between gap-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5 text-sm">
                            <a href="{{ route('reviewers.show', $review->user) }}" class="font-bold text-[#990000] hover:underline">
                                {{ $review->user->name }}
                            </a>
                            <x-rating :value="$review->rating" />
                            <span class="text-xs text-neutral-500">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <p class="text-sm text-neutral-800">{{ $review->body }}</p>
                    </div>

                    <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-medium text-neutral-500 hover:text-[#990000] hover:underline">
                            Delete
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-neutral-500">No reviews yet.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection