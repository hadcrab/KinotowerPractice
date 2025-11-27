<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FilmController extends Controller
{
    public function index(Request $r)
    {
        $page = max(1, (int) $r->query("page", 1));
        $size = max(1, (int) $r->query("size", 10));
        $sortBy = $r->query("sortBy", "name");
        $sortDir =
            strtolower($r->query("sortDir", "asc")) === "desc" ? "desc" : "asc";
        $category = (int) $r->query("category", 0);
        $country = (int) $r->query("country", 0);
        $search = $r->query("search", null);

        $query = Film::query()
            ->select(
                "films.*",
                DB::raw(
                    "(SELECT AVG(ball) FROM ratings WHERE ratings.film_id = films.id) as ratingAvg",
                ),
            )
            ->with(["country:id,name", "categories:id,name"]);

        if ($category > 0) {
            $query->whereExists(function ($q) use ($category) {
                $q->from("categories_films")
                    ->whereRaw("categories_films.film_id = films.id")
                    ->where("categories_films.category_id", $category);
            });
        }

        if ($country > 0) {
            $query->where("country_id", $country);
        }

        if ($search) {
            $query->where("name", "like", "%" . $search . "%");
        }

        if ($sortBy === "year") {
            $query->orderBy("year_of_issue", $sortDir);
        } elseif ($sortBy === "rating") {
            $query->orderBy("ratingAvg", $sortDir);
        } else {
            $query->orderBy("name", $sortDir);
        }

        $paginator = $query->paginate($size, ["*"], "page", $page);

        $films = $paginator
            ->getCollection()
            ->transform(function ($film) {
                $created = $film->created_at
                    ? Carbon::parse($film->created_at)->format(
                        "Y-m-d\TH:i:s.000\Z",
                    )
                    : null;

                return [
                    "id" => (int) $film->id,
                    "name" => $film->name,
                    "duration" => (int) $film->duration,
                    "year_of_issue" => (int) $film->year_of_issue,
                    "age" => $film->age,
                    "link_img" => $film->link_img ?? null,
                    "link_kinopoisk" => $film->link_kinopoisk ?? null,
                    "link_video" => $film->link_video,
                    "created_at" => $created,
                    "country" => $film->country
                        ? [
                            "id" => (int) $film->country->id,
                            "name" => $film->country->name,
                        ]
                        : null,
                    "categories" => $film->categories
                        ->map(function ($c) {
                            return ["id" => (int) $c->id, "name" => $c->name];
                        })
                        ->values()
                        ->all(),
                    "ratingAvg" =>
                        $film->ratingAvg !== null
                            ? round((float) $film->ratingAvg, 2)
                            : null,
                    "reviewCount" => (int) \DB::table("reviews")
                        ->where("film_id", $film->id)
                        ->where("is_approved", 1)
                        ->count(),
                ];
            })
            ->all();

        return response()->json(
            [
                "page" => (int) $paginator->currentPage(),
                "size" => count($films),
                "total" => (int) $paginator->total(),
                "films" => $films,
            ],
            200,
        );
    }

    public function show($id)
    {
        $film = Film::with(["country:id,name", "categories:id,name"])->find(
            $id,
        );
        if (!$film) {
            return response()->json(["message" => "Film not found"], 404);
        }

        $created = $film->created_at
            ? \Carbon\Carbon::parse($film->created_at)->format(
                "Y-m-d\TH:i:s.000\Z",
            )
            : null;
        $ratingAvg = \DB::table("ratings")
            ->where("film_id", $film->id)
            ->avg("ball");
        $reviewCount = \DB::table("reviews")
            ->where("film_id", $film->id)
            ->where("is_approved", 1)
            ->count();

        return response()->json(
            [
                "id" => (int) $film->id,
                "name" => $film->name,
                "duration" => (int) $film->duration,
                "year_of_issue" => (int) $film->year_of_issue,
                "age" => $film->age,
                "link_img" => $film->link_img ?? null,
                "link_kinopoisk" => $film->link_kinopoisk ?? null,
                "link_video" => $film->link_video,
                "created_at" => $created,
                "country" => $film->country
                    ? [
                        "id" => (int) $film->country->id,
                        "name" => $film->country->name,
                    ]
                    : null,
                "categories" => $film->categories
                    ->map(fn($c) => ["id" => (int) $c->id, "name" => $c->name])
                    ->values()
                    ->all(),
                "ratingAvg" =>
                    $ratingAvg !== null ? round((float) $ratingAvg, 2) : null,
                "reviewCount" => (int) $reviewCount,
            ],
            200,
        );
    }
}
