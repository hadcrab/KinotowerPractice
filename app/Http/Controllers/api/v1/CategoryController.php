<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::with("parentCategory")
            ->get()
            ->map(function ($c) {
                return [
                    "id" => (int) $c->id,
                    "name" => $c->name,
                    "parentCategory" => $c->parentCategory
                        ? [
                            "id" => (int) $c->parentCategory->id,
                            "name" => $c->parentCategory->name,
                        ]
                        : null,
                    "filmCount" => (int) \DB::table("categories_films")
                        ->where("category_id", $c->id)
                        ->count(),
                ];
            });

        return response()->json(["categories" => $cats], 200);
    }
}
