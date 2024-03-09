<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Image extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_image';

    protected $fillable = [
        'img_name',
        'path',
    ];



    public function flower(): HasOne
    {
        return $this->hasOne(Flower::class);
    }
}
