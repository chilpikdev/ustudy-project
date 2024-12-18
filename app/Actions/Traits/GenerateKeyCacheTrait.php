<?php

namespace App\Actions\Traits;

trait GenerateKeyCacheTrait
{
    /**
     * Summary of generateKey
     * @return string
     */
    public function generateKey(): string
    {
        $uri = request()->getUri();

        return '_' . app()->getLocale() . '_' . sha1($uri);
    }
}
