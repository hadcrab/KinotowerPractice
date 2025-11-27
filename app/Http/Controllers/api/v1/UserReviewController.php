<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;
use App\Models\Film;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserReviewController extends Controller
{
    public function store(Request $r, $userId)
    {
        if ($r->user()->id != (int) $userId) {
            return response()->json(["message" => "Forbidden"], 403);
        }

        $data = $r->validate([
            "film_id" => "required|exists:films,id",
            "message" => "required|string|min:4|max:1024",
        ]);

        $review = Review::create([
            "film_id" => $data["film_id"],
            "user_id" => $r->user()->id,
            "message" => $data["message"],
            "is_approved" => 0,
            "created_at" => Carbon::now(),
        ]);

        $film = Film::find($review->film_id);

        return response()->json(
            [
                "id" => (int) $review->id,
                "film" => ["id" => (int) $film->id, "name" => $film->name],
                "message" => $review->message,
                "is_approved" => (int) $review->is_approved,
                "created_at" => Carbon::parse($review->created_at)->format(
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

        $reviews = Review::where("user_id", $userId)
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
                    "message" => $r->message,
                    "is_approved" => (int) $r->is_approved,
                    "created_at" => Carbon::parse($r->created_at)->format(
                        "Y-m-d\TH:i:s.000\Z",
                    ),
                ];
            });

        return response()->json(["reviews" => $reviews], 200);
    }

    public function destroy(Request $r, $userId, $id)
    {
        if ($r->user()->id != (int) $userId) {
            return response()->json(["message" => "Forbidden"], 403);
        }
        $review = Review::find($id);
        if (!$review) {
            return response()->json(["message" => "Review not found"], 404);
        }
        if ($review->user_id != $r->user()->id) {
            return response()->json(["message" => "Forbidden"], 403);
        }

        $review->delete();
        return response()->json(null, 204);
    }
}
