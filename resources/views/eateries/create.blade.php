@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl sm:text-3xl font-bold text-[#990000] mb-6">Add New Eatery</h1>

    <form method="POST" action="{{ route('eateries.store') }}" class="bg-white border border-neutral-300 rounded-sm p-6 sm:p-8">
        @csrf
        @include('eateries._form')

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="bg-[#990000] text-white text-sm font-bold px-6 py-2 rounded-sm hover:bg-[#770000] transition-colors">
                Save Eatery
            </button>
            <a href="{{ route('eateries.index') }}" class="text-sm text-neutral-600 hover:text-[#990000] hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection