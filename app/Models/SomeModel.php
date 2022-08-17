<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SomeModel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array'
    ];

    public function allImages()
    {
        return $this->morphMany(Image::class, 'imagable');
    }
}
