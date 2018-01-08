<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body'];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
