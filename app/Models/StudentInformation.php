<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInformation extends Model
{
    use HasFactory;
    protected $table = 'student_information';
    protected $fillable = [
        'user_id',
        'weekly_schedule',
        'classes',
        'class_start_date'
    ];

    public function student(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
