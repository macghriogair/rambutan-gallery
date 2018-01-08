<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'url',
        'thumb_url',
        'metadata'
    ];

    protected $casts = [
        'is_public' => 'boolean'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->orderBy('created_at', 'desc');
    }

    // Smart Collection: recently created
    public static function scopeRecent(Builder $query, int $take = 20)
    {
        return $query->orderBy('created_at', 'desc')
            ->take($take);
    }

    // Smart Collection: public
    public static function scopePublic(Builder $query)
    {
        return $query->where('is_public', '=', true);
    }

    // Smart Collection: not belonging to Album
    public static function scopeUnsorted(Builder $query)
    {
        return $query->doesntHave('album');
    }

    // Smart Collection: starred by User
    public static function scopeStarred(Builder $query, User $user)
    {
        return $user->favorites()->getQuery();
    }
}
