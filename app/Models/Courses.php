<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'duration',
        'cost',
        'level',
        'timing',
        'image',
        'logo',
        'status'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Categories', 'category_id');
    }

    protected $hidden = [
        'image',
        'logo'
    ];

    protected $appends = ['image_full_url', 'logo_full_url'];


    public function getImageFullUrlAttribute()
    {
        if ($this->image) {
            return asset("/storage/uploads/{$this->image}");
        } else {
            return null;
        }
    }

    public function getLogoFullUrlAttribute()
    {
        if ($this->logo) {
            return asset("/storage/uploads/{$this->logo}");
        } else {
            return null;
        }
    }

    public function units(){
        return $this->hasMany('App\Models\Units', 'course_id');
    }
}
