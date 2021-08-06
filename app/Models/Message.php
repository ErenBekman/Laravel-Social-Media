<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'text' , 'time', 'userId' , 'me'
    ];

    public function conversation(){
        return $this->belongsTo(Message::class);
    }
}
