<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = [
        'to_id',
        'from_id',
        'message',
        'unread_status',
        'new_status'
    ];

    public function to_user(){
        return $this->belongsTo('App\Models\User', 'to_id');
    }

    public function from_user(){
        return $this->belongsTo('App\Models\User', 'from_id');
    }
}
