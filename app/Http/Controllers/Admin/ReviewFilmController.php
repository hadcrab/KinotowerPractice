<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Film;
use Illuminate\Http\Request;

class ReviewFilmController extends Controller
{
    public function index(Request $request)
    {
        $filmId = $request->query("film_id");

        $reviews = $filmId
            ? Review::where("film_id", $filmId)->paginate(20)
            : Review::paginate(20);

        $films = Film::all();

        return view(
            "admin.reviews.index",
            compact("reviews", "films", "filmId"),
        );
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->approved = 1;
        $review->save();

        return back()->with("success", "Review approved");
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with("success", "Review deleted");
    }
}
