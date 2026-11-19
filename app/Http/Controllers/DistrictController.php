<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('eateries')->orderBy('name')->get();

        return view('districts.index', compact('districts'));
    }

    public function show(District $district)
    {
        $eateries = $district->eateries()
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('name')
            ->get();

        $reviewsCount = $district->reviews()->count();

        return view('districts.show', compact('district', 'eateries', 'reviewsCount'));
    }
}