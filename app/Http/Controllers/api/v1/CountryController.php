<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all()->map(function ($c) {
            return [
                "id" => (int) $c->id,
                "name" => $c->name,
                "filmCount" => (int) \DB::table("films")
                    ->where("country_id", $c->id)
                    ->count(),
            ];
        });

        return response()->json(["countries" => $countries], 200);
    }
}
