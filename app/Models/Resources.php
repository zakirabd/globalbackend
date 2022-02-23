<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'teacher_id',
        'title',
        'attachment',
        'status'
    ];

    public function teacher(){
        return $this->belongsTo('App\Models\Users', 'teacher_id');
    }
}
