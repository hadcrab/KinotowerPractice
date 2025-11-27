<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryFilm extends Model
{
    protected $table = "category_films";

    public $timestamps = false;

    protected $fillable = ["film_id", "category_id"];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
