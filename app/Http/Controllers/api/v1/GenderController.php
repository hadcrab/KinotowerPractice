<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Gender;

class GenderController extends Controller
{
    public function index()
    {
        $genders = Gender::all()->map(
            fn($g) => ["id" => (int) $g->id, "name" => $g->name],
        );
        return response()->json(["genders" => $genders], 200);
    }
}
