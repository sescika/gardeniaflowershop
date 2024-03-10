<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'type'
    ];
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d.m.Y | H:i:m');
    }

    protected $appends = ['formattedDate'];
}
