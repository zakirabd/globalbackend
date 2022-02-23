<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    protected $table = 'units';

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'module',
        'admission',
        'online',
        'image',
        'logo',
        'status'
    ];
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

    public function course(){
        return $this->belongsTo('App\Models\Courses', 'course_id');
    }
}
