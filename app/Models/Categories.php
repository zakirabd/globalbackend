<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'title',
        'image',
        'description',
        'status'
    ];
    protected $hidden = [
        'image',
    ];

    protected $appends = ['image_full_url'];


    public function getImageFullUrlAttribute()
    {
        if ($this->image) {
            return asset("/storage/uploads/{$this->image}");
        } else {
            return null;
        }
    }

    public function courses(){
        return $this->hasMany('App\Models\Courses', 'category_id')->with('units');
    }
}
