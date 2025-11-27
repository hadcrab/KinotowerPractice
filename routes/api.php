<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FilmController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\GenderController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UserReviewController;
use App\Http\Controllers\Api\V1\UserRatingController;
use App\Http\Controllers\Api\V1\FilmReviewController;
use App\Http\Controllers\Api\V1\FilmRatingController;

Route::prefix("v1")->group(function () {
    // open
    Route::get("/films", [FilmController::class, "index"]);
    Route::get("/films/{id}", [FilmController::class, "show"]);
    Route::get("/films/{film}/reviews", [FilmReviewController::class, "index"]);

    Route::get("/categories", [CategoryController::class, "index"]);
    Route::get("/countries", [CountryController::class, "index"]);
    Route::get("/genders", [GenderController::class, "index"]);

    // auth
    Route::post("/auth/signup", [AuthController::class, "signup"]);
    Route::post("/auth/signin", [AuthController::class, "signin"]);

    // protected
    Route::middleware("auth:sanctum")->group(function () {
        Route::post("/auth/signout", [AuthController::class, "signout"]);

        // user profile & lists
        Route::get("/users/{id}", [UserController::class, "show"]);
        Route::put("/users", [UserController::class, "update"]);
        Route::delete("/users", [UserController::class, "destroy"]);

        // user reviews / ratings (user operates on own id)
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

        // film reviews & ratings management (delete review/rating by id)
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
