@if ($errors->any())
    <div class="mb-6 rounded-sm border border-red-300 bg-red-50 p-4 text-sm text-[#990000]">
        <p class="font-bold mb-1">Please fix the errors below:</p>
        <ul class="list-disc pl-5 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $selectedFeatures = old('features', isset($eatery) ? $eatery->features->pluck('id')->all() : []);
    $isOpenChecked = old('is_open', isset($eatery) ? $eatery->is_open : true);
@endphp

<div class="space-y-5">
    <div>
        <label for="name" class="block text-sm font-bold text-neutral-800 mb-1">Eatery Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $eatery->name ?? '') }}"
               class="w-full bg-white border border-neutral-300 rounded-sm px-3.5 py-2 text-sm focus:outline-none focus:border-[#990000]">
        @error('name') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="district_id" class="block text-sm font-bold text-neutral-800 mb-1">District</label>
            <select id="district_id" name="district_id" class="w-full bg-white border border-neutral-300 rounded-sm px-3.5 py-2 text-sm focus:outline-none focus:border-[#990000]">
                <option value="">Select district</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected(old('district_id', $eatery->district_id ?? '') == $district->id)>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
            @error('district_id') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="price_range" class="block text-sm font-bold text-neutral-800 mb-1">Price Range</label>
            <select id="price_range" name="price_range" class="w-full bg-white border border-neutral-300 rounded-sm px-3.5 py-2 text-sm focus:outline-none focus:border-[#990000]">
                <option value="">Select price range</option>
                <option value="budget" @selected(old('price_range', $eatery->price_range ?? '') === 'budget')>Budget (₱)</option>
                <option value="mid" @selected(old('price_range', $eatery->price_range ?? '') === 'mid')>Mid (₱₱)</option>
                <option value="splurge" @selected(old('price_range', $eatery->price_range ?? '') === 'splurge')>Splurge (₱₱₱)</option>
            </select>
            @error('price_range') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="address" class="block text-sm font-bold text-neutral-800 mb-1">Address</label>
        <input type="text" id="address" name="address" value="{{ old('address', $eatery->address ?? '') }}"
               class="w-full bg-white border border-neutral-300 rounded-sm px-3.5 py-2 text-sm focus:outline-none focus:border-[#990000]">
        @error('address') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="specialty" class="block text-sm font-bold text-neutral-800 mb-1">Specialty (optional)</label>
        <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $eatery->specialty ?? '') }}"
               class="w-full bg-white border border-neutral-300 rounded-sm px-3.5 py-2 text-sm focus:outline-none focus:border-[#990000]">
        @error('specialty') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="inline-flex items-center gap-2 text-sm font-bold text-neutral-800">
            <input type="checkbox" name="is_open" value="1" @checked($isOpenChecked) class="rounded-sm border-neutral-400 text-[#990000]">
            Currently Open
        </label>
        @error('is_open') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div class="border-t border-neutral-200 pt-5">
        <span class="block text-sm font-bold text-neutral-800 mb-2">Features</span>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2 text-sm text-neutral-700">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                           @checked(is_array($selectedFeatures) && in_array($feature->id, $selectedFeatures))
                           class="rounded-sm border-neutral-400 text-[#990000]">
                    {{ $feature->name }}
                </label>
            @endforeach
        </div>
        @error('features') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
        @error('features.*') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
    </div>

    <div class="border-t border-neutral-200 pt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="permit_no" class="block text-sm font-bold text-neutral-800 mb-1">Business Permit Number</label>
            <input type="text" id="permit_no" name="permit_no" placeholder="DVO-2026-0415"
                   value="{{ old('permit_no', isset($eatery) ? $eatery->permit?->permit_no : '') }}"
                   class="w-full bg-white border border-neutral-300 rounded-sm px-3.5 py-2 text-sm focus:outline-none focus:border-[#990000]">
            @error('permit_no') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="expires_on" class="block text-sm font-bold text-neutral-800 mb-1">Permit Expiry Date</label>
            <input type="date" id="expires_on" name="expires_on"
                   value="{{ old('expires_on', isset($eatery) && $eatery->permit?->expires_on ? $eatery->permit->expires_on->format('Y-m-d') : '') }}"
                   class="w-full bg-white border border-neutral-300 rounded-sm px-3.5 py-2 text-sm focus:outline-none focus:border-[#990000]">
            @error('expires_on') <p class="text-[#990000] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
        </div>
    </div>
</div>