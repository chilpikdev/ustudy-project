<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Phone extends Model
{
    protected $table = 'phones';

    protected $fillable = [
        'number'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of phoneable
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function phoneable(): MorphTo
    {
        return $this->morphTo();
    }
}
