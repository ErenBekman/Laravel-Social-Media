<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Wallpaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'media_id'  
    ];

    // public function media()
    // {
    // 	return $this->belongsTo(Media::class);
    // }

    
}
