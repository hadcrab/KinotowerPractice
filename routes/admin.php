<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilmController;

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
});
