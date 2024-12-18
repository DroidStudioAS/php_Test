<?php

namespace App\Exceptions;

use Exception;

class JuicerException extends Exception
{
    public static function containerFull(float $capacity): self
    {
        return new self("Container is full. Maximum capacity is {$capacity}L");
    }

    public static function invalidCapacity(float $capacity): self
    {
        return new self("Invalid capacity: {$capacity}. Capacity must be greater than 0.");
    }

} 