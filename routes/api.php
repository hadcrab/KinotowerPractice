<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\FilmController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\CountryController;
use App\Http\Controllers\api\v1\GenderController;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\UserReviewController;
use App\Http\Controllers\api\v1\UserRatingController;
use App\Http\Controllers\api\v1\FilmReviewController;
use App\Http\Controllers\api\v1\FilmRatingController;

Route::prefix("v1")->group(function () {
    Route::get("/films", [FilmController::class, "index"]);
    Route::get("/films/{id}", [FilmController::class, "show"]);
    Route::get("/films/{film}/reviews", [FilmReviewController::class, "index"]);

    Route::get("/categories", [CategoryController::class, "index"]);
    Route::get("/countries", [CountryController::class, "index"]);
    Route::get("/genders", [GenderController::class, "index"]);

    Route::post("/auth/signup", [AuthController::class, "signup"]);
    Route::post("/auth/signin", [AuthController::class, "signin"]);

    Route::middleware("auth:sanctum")->group(function () {
        Route::post("/auth/signout", [AuthController::class, "signout"]);

        Route::get("/users/{id}", [UserController::class, "show"]);
        Route::put("/users", [UserController::class, "update"]);
        Route::delete("/users", [UserController::class, "destroy"]);

        Route::post("/users/{user}/reviews", [
            UserReviewController::class,
            "store",
        ]);
        Route::get("/users/{user}/reviews", [
            UserReviewController::class,
            "index",
        ]);
        Route::delete("/users/{user}/reviews/{id}", [
            UserReviewController::class,
            "destroy",
        ]);

        Route::post("/users/{user}/ratings", [
            UserRatingController::class,
            "store",
        ]);
        Route::get("/users/{user}/ratings", [
            UserRatingController::class,
            "index",
        ]);
        Route::delete("/users/{user}/ratings/{id}", [
            UserRatingController::class,
            "destroy",
        ]);

        Route::post("/reviews/{id}/approve", [
            FilmReviewController::class,
            "approve",
        ]);
        Route::delete("/reviews/{id}", [
            FilmReviewController::class,
            "destroy",
        ]);

        Route::get("/films/{film}/ratings", [
            FilmRatingController::class,
            "index",
        ]);
        Route::post("/films/{film}/ratings", [
            FilmRatingController::class,
            "store",
        ]);
        Route::delete("/ratings/{id}", [
            FilmRatingController::class,
            "destroy",
        ]);
    });
});
