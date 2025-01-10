<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Country extends Model
{
    protected $fillable = [
        'name'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            related: User::class,
            through: Profile::class,
            firstKey: 'country_id',
            secondKey: 'id',
            localKey: 'id',
            secondLocalKey: 'user_id'
        );
    }

    /**
     * Summary of posts
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(
            related: Post::class,
            through: User::class,
            firstKey: 'country_id',
            secondKey: 'user_id',
            localKey: 'id',
            secondLocalKey: 'id'
        );
    }
}
