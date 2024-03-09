<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Flower extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $fillable = [
        'flower_name',
        'active',
        'image_id',
    ];

    protected $primaryKey = 'id_flower';

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id', 'id_image');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_flowers', 'flower_id', null, null, 'id_category');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'flower_id', 'id_flower');
    }

    public function currentPricing(): HasOne
    {
        return $this->hasOne(Price::class, 'flower_id')->ofMany('id_price', "MAX")->where('effective_date', '>', now());
    }
}
