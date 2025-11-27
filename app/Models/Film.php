<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "name",
        "country_id",
        "duration",
        "year_of_issue",
        "age",
        "link_img",
        "link_kinopoisk",
        "link_video",
    ];
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            "categories_films",
            "film_id",
            "category_id",
        );
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
