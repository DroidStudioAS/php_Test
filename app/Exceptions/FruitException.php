<?php

namespace App\Exceptions;

use Exception;

class FruitException extends Exception
{
    public static function invalidVolume(float $volume): self
    {
        return new self("Invalid fruit volume: {$volume}. Volume must be greater than 0.");
    }

    public static function invalidColor(string $color): self
    {
        return new self("Invalid fruit color: {$color}. Color cannot be empty.");
    }
} 