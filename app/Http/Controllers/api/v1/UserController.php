<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::with("gender")->find($id);
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        $reviewCount = \DB::table("reviews")
            ->where("user_id", $user->id)
            ->count();
        $ratingCount = \DB::table("ratings")
            ->where("user_id", $user->id)
            ->count();

        return response()->json(
            [
                "id" => (int) $user->id,
                "fio" => $user->fio,
                "email" => $user->email,
                "birthday" => $user->birthday,
                "gender" => $user->gender
                    ? [
                        "id" => (int) $user->gender->id,
                        "name" => $user->gender->name,
                    ]
                    : null,
                "reviewCount" => (int) $reviewCount,
                "ratingCount" => (int) $ratingCount,
            ],
            200,
        );
    }

    public function update(Request $r)
    {
        $user = $r->user();
        $data = $r->validate([
            "fio" => "required|string|min:2|max:150",
            "email" => [
                "required",
                "email",
                "min:4",
                "max:50",
                Rule::unique("users", "email")->ignore($user->id),
            ],
            "birthday" => "required|date",
            "gender_id" => "required|exists:genders,id",
        ]);

        $user->update($data);
        return response()->json(["status" => "success"], 200);
    }

    public function destroy(Request $r)
    {
        $user = $r->user();
        $user->delete();
        return response()->json(null, 204);
    }
}
