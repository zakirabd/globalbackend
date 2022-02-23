<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lessons extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $fillable = [
        'unit_id',
        'title',
        'description',
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

    public function unit(){
        return $this->belongsTo('App\Models\Units', 'unit_id');
    }
}
