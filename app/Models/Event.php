<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [        
        'calendarId',
        'title',
        'body',
        'isAllday',
        'start',
        'end',
        'category',
        'dueDateClass',
        'color',
        'bgColor',
        'dragBgColor',
        'borderColor',
        'customStyle',
        'isFocused',
        'isPending',
        'isVisible',
        'isReadOnly',
        'goingDuration',
        'comingDuration',
        'recurrenceRule',
        'state',
        'raw',
        'isPrivate',
        'location',
        'attendees',
    
    ];
    protected $casts = [
        'raw' => 'array',
        'attendees' => 'array'
    ];
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
