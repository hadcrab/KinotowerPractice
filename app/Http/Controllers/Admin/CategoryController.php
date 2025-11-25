<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view("admin.categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("admin.categories.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        Category::create($data);
        return redirect()->route("categories.index");
    }

    public function edit(string $id)
    {
        $categories = Category::all();
        $category = category::findOrFail($id);
        return view(
            "admin.categories.create",
            compact("categories", "category"),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $data = $request->validated();
        $category = category::findOrFail($id);
        $category->update($data);
        return redirect()->route("categories.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return redirect()->route("categories.index");
    }
}
