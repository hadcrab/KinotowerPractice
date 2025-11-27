<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FilmReviewController extends Controller
{
    public function index($filmId)
    {
        $film = Film::find($filmId);
        if (!$film) {
            return response()->json(["message" => "Film not found"], 404);
        }

        $reviews = Review::where("film_id", $filmId)
            ->where("is_approved", 1)
            ->with("user:id,fio")
            ->orderByDesc("created_at")
            ->get()
            ->map(function ($r) {
                return [
                    "id" => (int) $r->id,
                    "user" => [
                        "id" => (int) $r->user->id,
                        "fio" => $r->user->fio,
                    ],
                    "message" => $r->message,
                    "created_at" => Carbon::parse($r->created_at)->format(
                        "Y-m-d\TH:i:s.000\Z",
                    ),
                ];
            });

        return response()->json(["reviews" => $reviews], 200);
    }

    public function approve($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(["message" => "Review not found"], 404);
        }
        $review->is_approved = 1;
        $review->save();
        return response()->json(["status" => "success"], 200);
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(["message" => "Review not found"], 404);
        }
        $review->delete();
        return response()->json(null, 204);
    }
}
