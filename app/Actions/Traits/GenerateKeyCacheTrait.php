<?php

namespace App\Actions\Traits;

trait GenerateKeyCacheTrait
{
    /**
     * Summary of generateKey
     */
    public function generateKey(): string
    {
        $uri = request()->getUri();

        return '_'.app()->getLocale().'_'.sha1($uri);
    }
}
