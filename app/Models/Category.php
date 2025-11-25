<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function Categories(){
        return $this->hasMany(Category::class);
    }

    public function parentCategory() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function films() {
        return $this->belongsToMany(Film::class, 'category_films');
    }
}
