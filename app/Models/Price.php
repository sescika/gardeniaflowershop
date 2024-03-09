<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Price extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_price';
    protected $fillable = [
        'flower_id',
        'price',
        'currency_code',
        'effective_date',
    ];

    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }
}
