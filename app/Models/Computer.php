<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Computer extends Model
{
    protected $table = 'computers';

    protected $fillable = [
        'model'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of computable
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function computable(): MorphTo
    {
        return $this->morphTo();
    }
}
