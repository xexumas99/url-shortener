<?php

namespace App\Helper;


class BearerTokenHelper
{
    public static function isBearerTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        if (strpos($token, 'Bearer ') !== 0) {
            return false;
        }

        $stack = [];
        $map = [
            ']' => '[',
            '}' => '{',
            ')' => '(',
        ];

        for ($i = 0; $i < strlen($token); $i++) {
            $char = $token[$i];

            if (in_array($char, ['[', '{', '('])) {
                array_push($stack, $char);
            } elseif (in_array($char, [']', '}', ')'])) {
                $expected = $map[$char];

                if (empty($stack) || array_pop($stack) != $expected) {
                    return false;
                }
            }
        }

        return empty($stack);
    }
}
