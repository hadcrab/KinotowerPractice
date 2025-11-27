<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Country;
use App\Models\Category;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $query = Film::query()->with(["country"]);

        if ($request->country_id) {
            $query->where("country_id", $request->country_id);
        }

        if ($request->category_id) {
            $query->whereHas("categories", function ($q) use ($request) {
                $q->where("id", $request->category_id);
            });
        }

        $films = $query->paginate(10);

        $films->load([
            "reviews" => function ($q) {
                $q->with("user")->orderByDesc("created_at");
            },
            "ratings" => function ($q) {
                $q->with("user")->orderByDesc("created_at");
            },
        ]);

        return view("admin.films.index", [
            "films" => $films,
            "countries" => Country::all(),
            "categories" => Category::all(),
        ]);
    }

    public function create()
    {
        return view("admin.films.form", [
            "countries" => Country::all(),
            "categories" => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $film = Film::create(
            $request->only([
                "name",
                "country_id",
                "duration",
                "year_of_issue",
                "age",
                "link_img",
                "link_kinopoisk",
                "link_video",
            ]),
        );

        $film->categories()->sync($request->categories ?? []);

        return redirect()->route("films.index");
    }

    public function edit(Film $film)
    {
        return view("admin.films.form", [
            "film" => $film,
            "countries" => Country::all(),
            "categories" => Category::all(),
            "selected_categories" => $film->categories->pluck("id")->toArray(),
        ]);
    }

    public function update(Request $request, Film $film)
    {
        $film->update(
            $request->only([
                "name",
                "country_id",
                "duration",
                "year_of_issue",
                "age",
                "link_img",
                "link_kinopoisk",
                "link_video",
            ]),
        );

        $film->categories()->sync($request->categories ?? []);

        return redirect()->route("films.index");
    }

    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route("films.index");
    }

    public function approveReview($reviewId)
    {
        $review = \App\Models\Review::findOrFail($reviewId);
        $review->is_approved = true;
        $review->save();

        return redirect()->back();
    }

    public function deleteReview($reviewId)
    {
        $review = \App\Models\Review::findOrFail($reviewId);
        $review->delete();

        return redirect()->back();
    }

    public function deleteRating($ratingId)
    {
        $rating = \App\Models\Rating::findOrFail($ratingId);
        $rating->delete();

        return redirect()->back();
    }
}
