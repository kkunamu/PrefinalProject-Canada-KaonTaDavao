<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    public function index(Request $request)
    {
        $query = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('specialty', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('district')) {
            $query->where('district_id', $request->district);
        }

        if ($request->filled('feature')) {
            $query->whereHas('features', function ($q) use ($request) {
                $q->where('name', $request->feature);
            });
        }

        $eateries = $query->orderBy('name')->paginate(6)->withQueryString();
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    public function store(StoreEateryRequest $request)
    {
        $validated = $request->validated();

        $eatery = Eatery::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'district_id' => $validated['district_id'],
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => $validated['is_open'],
        ]);

        $eatery->permit()->create([
            'permit_no' => $validated['permit_no'],
            'expires_on' => $validated['expires_on'],
        ]);

        $eatery->features()->sync($validated['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery added.');
    }

    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'permit',
            'features',
            'dishes',
            'reviews' => fn ($q) => $q->latest(),
            'reviews.user',
        ]);

        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    public function edit(Eatery $eatery)
    {
        $eatery->load(['permit', 'features']);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $validated = $request->validated();

        $eatery->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'district_id' => $validated['district_id'],
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => $validated['is_open'],
        ]);

        $eatery->permit()->updateOrCreate(
            ['eatery_id' => $eatery->id],
            [
                'permit_no' => $validated['permit_no'],
                'expires_on' => $validated['expires_on'],
            ]
        );

        $eatery->features()->sync($validated['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery)
    {
        $eatery->permit()->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()->route('eateries.index')->with('status', 'Eatery deleted.');
    }
}