@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-3 mb-6 border-b border-neutral-300">
    <h1 class="text-2xl sm:text-3xl font-bold text-[#990000]">All Eateries</h1>
    <a href="{{ route('eateries.create') }}" class="inline-block bg-[#990000] text-white text-sm font-medium px-4 py-2 rounded-sm hover:bg-[#770000] transition-colors">
        + Add Eatery
    </a>
</div>

<form method="GET" action="{{ route('eateries.index') }}" class="bg-neutral-100 border border-neutral-300 rounded-sm p-4 mb-6 grid grid-cols-1 sm:grid-cols-4 gap-3">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or specialty..."
           class="bg-white border border-neutral-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-[#990000]">

    <select name="district" class="bg-white border border-neutral-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-[#990000]">
        <option value="">All Districts</option>
        @foreach ($districts as $district)
            <option value="{{ $district->id }}" @selected(request('district') == $district->id)>
                {{ $district->name }}
            </option>
        @endforeach
    </select>

    <select name="feature" class="bg-white border border-neutral-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-[#990000]">
        <option value="">All Features</option>
        @foreach ($features as $feature)
            <option value="{{ $feature->name }}" @selected(request('feature') == $feature->name)>
                {{ $feature->name }}
            </option>
        @endforeach
    </select>

    <div class="flex gap-2">
        <button type="submit" class="flex-1 bg-[#990000] text-white text-sm font-medium px-4 py-2 rounded-sm hover:bg-[#770000] transition-colors">
            Filter
        </button>
        @if (request()->anyFilled(['q', 'district', 'feature']))
            <a href="{{ route('eateries.index') }}" class="px-3 py-2 text-sm bg-white text-neutral-700 border border-neutral-300 rounded-sm hover:bg-neutral-200">
                Reset
            </a>
        @endif
    </div>
</form>

@if ($eateries->isEmpty())
    <div class="bg-white border border-neutral-300 rounded-sm p-10 text-center text-neutral-600 font-medium">
        No eateries match your filters.
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        @foreach ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @endforeach
    </div>

    <div>
        {{ $eateries->links() }}
    </div>
@endif
@endsection