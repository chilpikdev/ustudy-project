<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestCollection;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use ResponseTrait;

    public function __invoke()
    {
        $items = Post::query();

        $items = $items->paginate();

        return static::toResponse(
            data: new TestCollection($items)
        );
    }
}
