<?php

namespace App\Tests\Unit\Helper;

use App\Helper\BearerTokenHelper;
use PHPUnit\Framework\TestCase;

class BearerTokenHelperTest extends TestCase
{
    public function testIsBearerTokenValid(): void
    {
        $this->assertTrue(BearerTokenHelper::isBearerTokenValid('Bearer {}'));
        $this->assertTrue(BearerTokenHelper::isBearerTokenValid('Bearer {}[]()'));
        $this->assertFalse(BearerTokenHelper::isBearerTokenValid('Bearer {)'));
        $this->assertFalse(BearerTokenHelper::isBearerTokenValid('Bearer [{]}'));
        $this->assertTrue(BearerTokenHelper::isBearerTokenValid('Bearer {([])}'));
        $this->assertFalse(BearerTokenHelper::isBearerTokenValid('Bearer (((((((()'));

        $this->assertTrue(BearerTokenHelper::isBearerTokenValid('Bearer '));
        $this->assertFalse(BearerTokenHelper::isBearerTokenValid('Bear'));
        $this->assertFalse(BearerTokenHelper::isBearerTokenValid(''));
        
        $this->assertTrue(BearerTokenHelper::isBearerTokenValid('Bearer Hello World'));
        $this->assertFalse(BearerTokenHelper::isBearerTokenValid('Hello Bearer World'));
        $this->assertFalse(BearerTokenHelper::isBearerTokenValid('Bearer (Helo World'));
        $this->assertTrue(BearerTokenHelper::isBearerTokenValid('Bearer (Helo World)'));
    }
}
