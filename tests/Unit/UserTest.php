<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_user_full_name(): void
    {
        $user = new User(['first_name' => 'Test', 'last_name' => 'User']);
        $this->assertEquals('Test User', $user->full_name);
    }
}
