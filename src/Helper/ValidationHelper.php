<?php

namespace App\Helper;


class ValidationHelper
{
    public static function isValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
