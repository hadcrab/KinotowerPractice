<?php
namespace App\Http\Controllers\Admin;

use App\Models\Film;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryFilmController extends Controller
{
    public function index(Film $film)
    {
        $categories = Category::all();
        $filmCategories = $film->categories()->get();

        return view(
            "admin.films.categories.index",
            compact("film", "categories", "filmCategories"),
        );
    }

    public function store(Request $request, Film $film)
    {
        $request->validate([
            "category_id" => "required|exists:categories,id",
        ]);

        if (!$film->categories->contains($request->category_id)) {
            $film->categories()->attach($request->category_id);
        }

        return back()->with("success", "Category added.");
    }

    public function destroy(Film $film, Category $category)
    {
        $film->categories()->detach($category->id);

        return back()->with("success", "Category removed.");
    }
}
