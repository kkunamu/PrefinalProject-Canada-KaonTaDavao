<header class="bg-white border-t-4 border-b border-t-[#990000] border-b-neutral-300">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold text-[#990000] tracking-tight hover:text-red-800">
                Kaon Ta! Davao Cañada's Food Guide
            </a>
            <p class="text-xs text-neutral-500">Davao City Carinderia &amp; Eatery Directory</p>
        </div>

        <nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
            <a href="{{ route('home') }}" class="text-neutral-700 hover:text-[#990000] hover:underline">Home</a>
            <a href="{{ route('eateries.index') }}" class="text-neutral-700 hover:text-[#990000] hover:underline">Eateries</a>
            <a href="{{ route('districts.index') }}" class="text-neutral-700 hover:text-[#990000] hover:underline">Districts</a>
            <a href="{{ route('eateries.create') }}" class="bg-[#990000] text-white px-3.5 py-1.5 rounded-sm hover:bg-[#770000] transition-colors">
                + Add Eatery
            </a>
        </nav>
    </div>
</header>