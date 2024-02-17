<?php

namespace App\Tests\Unit\Helper;

use App\Helper\ValidationHelper;
use PHPUnit\Framework\TestCase;

class ValidationHelperTest extends TestCase
{
    public function testIsValidUrl(): void
    {
        $this->assertTrue(ValidationHelper::isValidUrl('https://www.google.com'));
        $this->assertTrue(ValidationHelper::isValidUrl('http://www.google.com'));
        
        $this->assertFalse(ValidationHelper::isValidUrl('www.google.com'));
        $this->assertFalse(ValidationHelper::isValidUrl('google.com'));
        $this->assertFalse(ValidationHelper::isValidUrl('google'));
        
        $this->assertTrue(ValidationHelper::isValidUrl('https://google.com'));        
    }
}
