@extends('layouts.app')

@section('content')
<h1 class="text-2xl sm:text-3xl font-bold text-[#990000] pb-3 mb-6 border-b border-neutral-300">Davao City Districts</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($districts as $district)
        <a href="{{ route('districts.show', $district) }}"
           class="bg-white border border-neutral-300 rounded-sm p-4 hover:border-[#990000] transition-colors flex items-center justify-between">
            <span class="font-bold text-[#990000] hover:underline">{{ $district->name }}</span>
            <span class="text-xs font-semibold text-neutral-700 bg-neutral-100 border border-neutral-300 px-2.5 py-0.5 rounded-sm">
                {{ $district->eateries_count }} {{ $district->eateries_count === 1 ? 'eatery' : 'eateries' }}
            </span>
        </a>
    @endforeach
</div>
@endsection