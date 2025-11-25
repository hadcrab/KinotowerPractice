<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return view("admin.countries.index", compact("countries"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.countries.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        $data = $request->validated();
        Country::create($data);
        return redirect()->route("countries.index");
    }

    public function edit(string $id)
    {
        $country = country::findOrFail($id);
        return view("admin.countries.create", compact("country"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, string $id)
    {
        $data = $request->validated();
        $country = country::findOrFail($id);
        $country->update($data);
        return redirect()->route("countries.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Country::destroy($id);
        return redirect()->route("countries.index");
    }
}
