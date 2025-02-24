<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'path',
        'name',
        'size',
        'extension',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of filelable
     * @return MorphTo<Model, File>
     */
    public function filelable(): MorphTo
    {
        return $this->morphTo();
    }
}
