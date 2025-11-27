<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function signup(Request $r)
    {
        $data = $r->validate([
            "fio" => "required|string|min:2|max:150",
            "email" => "required|email|min:4|max:50|unique:users,email",
            "password" => "required|string|min:6",
            "birthday" => "required|date",
            "gender_id" => "required|exists:genders,id",
        ]);

        $user = User::create([
            "fio" => $data["fio"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
            "birthday" => $data["birthday"],
            "gender_id" => $data["gender_id"],
            "created_at" => Carbon::now(),
        ]);

        $token = $user->createToken("api")->plainTextToken;

        return response()->json(
            [
                "status" => "success",
                "token" => $token,
                "id" => $user->id,
                "fio" => $user->fio,
            ],
            201,
        );
    }

    public function signin(Request $r)
    {
        $data = $r->validate([
            "email" => "required|email|min:4|max:50",
            "password" => "required|string|min:6",
        ]);

        $user = User::where("email", $data["email"])->first();
        if (!$user || !Hash::check($data["password"], $user->password)) {
            return response()->json(
                [
                    "status" => "invalid",
                    "message" => "Wrong email or password",
                ],
                401,
            );
        }

        $token = $user->createToken("api")->plainTextToken;

        return response()->json(
            [
                "status" => "success",
                "token" => $token,
                "id" => $user->id,
                "fio" => $user->fio,
            ],
            200,
        );
    }

    public function signout(Request $r)
    {
        $r->user()->currentAccessToken()->delete();
        return response()->json(["status" => "success"], 200);
    }
}
