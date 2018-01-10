<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['name', 'description'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
