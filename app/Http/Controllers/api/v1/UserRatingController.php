<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rating;
use App\Models\Film;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserRatingController extends Controller
{
    public function store(Request $r, $userId)
    {
        if ($r->user()->id != (int) $userId) {
            return response()->json(["message" => "Forbidden"], 403);
        }

        $data = $r->validate([
            "film_id" => "required|exists:films,id",
            "ball" => "required|integer|min:1|max:5",
        ]);

        $exists = Rating::where("film_id", $data["film_id"])
            ->where("user_id", $r->user()->id)
            ->exists();
        if ($exists) {
            return response()->json(
                ["status" => "invalid", "message" => "Score exist"],
                401,
            );
        }

        $rating = Rating::create([
            "film_id" => $data["film_id"],
            "user_id" => $r->user()->id,
            "ball" => $data["ball"],
            "created_at" => Carbon::now(),
        ]);

        $film = Film::find($rating->film_id);

        return response()->json(
            [
                "id" => (int) $rating->id,
                "film" => ["id" => (int) $film->id, "name" => $film->name],
                "score" => (int) $rating->ball,
                "created_at" => Carbon::parse($rating->created_at)->format(
                    "Y-m-d\TH:i:s.000\Z",
                ),
            ],
            201,
        );
    }

    public function index($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        $ratings = Rating::where("user_id", $userId)
            ->with("film:id,name")
            ->orderByDesc("created_at")
            ->get()
            ->map(function ($r) {
                return [
                    "id" => (int) $r->id,
                    "film" => [
                        "id" => (int) $r->film->id,
                        "name" => $r->film->name,
                    ],
                    "score" => (int) $r->ball,
                    "created_at" => Carbon::parse($r->created_at)->format(
                        "Y-m-d\TH:i:s.000\Z",
                    ),
                ];
            });

        return response()->json(["ratings" => $ratings], 200);
    }

    public function destroy(Request $r, $userId, $id)
    {
        if ($r->user()->id != (int) $userId) {
            return response()->json(["message" => "Forbidden"], 403);
        }
        $rating = Rating::find($id);
        if (!$rating) {
            return response()->json(["message" => "Rating not found"], 404);
        }
        if ($rating->user_id != $r->user()->id) {
            return response()->json(["message" => "Forbidden"], 403);
        }

        $rating->delete();
        return response()->json(null, 204);
    }
}
