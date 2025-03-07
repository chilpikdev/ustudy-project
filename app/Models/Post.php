<?php

namespace App\Models;

use App\Models\Traits\HasComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasComment, HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'content',
        'view',
        'shared',
        'recommended',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'recommended',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    #[\Override()]
    protected function casts(): array
    {
        return [
            'recommended' => 'bool',
        ];
    }

    /**
     * Summary of user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Summary of tags
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'posts_tags', 'post_id', 'tag_id');
    }

    /**
     * Summary of files
     * @return MorphMany<File, Post>
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
