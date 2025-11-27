<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Rating;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FilmRatingController extends Controller
{
    public function index($filmId)
    {
        $film = Film::find($filmId);
        if (!$film) {
            return response()->json(["message" => "Film not found"], 404);
        }

        $ratings = Rating::where("film_id", $filmId)
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
                    "score" => (int) $r->ball,
                    "created_at" => Carbon::parse($r->created_at)->format(
                        "Y-m-d\TH:i:s.000\Z",
                    ),
                ];
            });

        return response()->json(["ratings" => $ratings], 200);
    }

    public function store(Request $r, $filmId)
    {
        $data = $r->validate([
            "ball" => "required|integer|min:1|max:5",
        ]);

        $film = Film::find($filmId);
        if (!$film) {
            return response()->json(["message" => "Film not found"], 404);
        }

        $user = $r->user();

        $exists = Rating::where("film_id", $filmId)
            ->where("user_id", $user->id)
            ->exists();
        if ($exists) {
            return response()->json(
                ["status" => "invalid", "message" => "Score exist"],
                401,
            );
        }

        $rating = Rating::create([
            "film_id" => $filmId,
            "user_id" => $user->id,
            "ball" => $data["ball"],
            "created_at" => Carbon::now(),
        ]);

        return response()->json(
            [
                "id" => $rating->id,
                "film" => ["id" => (int) $film->id, "name" => $film->name],
                "score" => (int) $rating->ball,
                "created_at" => Carbon::parse($rating->created_at)->format(
                    "Y-m-d\TH:i:s.000\Z",
                ),
            ],
            201,
        );
    }

    public function destroy($id)
    {
        $rating = Rating::find($id);
        if (!$rating) {
            return response()->json(["message" => "Rating not found"], 404);
        }
        $rating->delete();
        return response()->json(null, 204);
    }
}
