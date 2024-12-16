<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'description',
        'view',
        'shared',
        'recommended',
        'created_at',
        'updated_at',
    ];

    #[\Override()]
    protected function casts(): array
    {
        return [
            'recommended' => 'bool',
        ];
    }
}
