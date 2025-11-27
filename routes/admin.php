<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\CategoryFilmController;

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return "Hello Admin";
});

Route::get("/login", [AuthController::class, "index"])->name("login");
Route::post("/login", [AuthController::class, "login"])->name("login.submit");

Route::middleware(["auth:admin"])->group(function () {
    Route::post("/logout", [AuthController::class, "logout"])->name("logout");
    Route::get("/", [MainController::class, "index"])->name("home");
    Route::resource("countries", CountryController::class)->except("show");
    Route::resource("categories", CategoryController::class)->except("show");
    Route::resource("films", FilmController::class);
    Route::prefix("films/{film}")->group(function () {
        Route::get("categories", [
            CategoryFilmController::class,
            "index",
        ])->name("film.categories.index");
        Route::post("categories", [
            CategoryFilmController::class,
            "store",
        ])->name("film.categories.store");
        Route::delete("categories/{category}", [
            CategoryFilmController::class,
            "destroy",
        ])->name("film.categories.destroy");
    });
});
