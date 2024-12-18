<?php

namespace App\Exceptions;

use Exception;

/**
 * Class FruitException
 * 
 * Exception class for handling fruit-related errors.
 * Provides specific exception messages for different validation failures.
 * 
 * @package App\Exceptions
 */
class FruitException extends Exception
{
    /**
     * Create an exception for invalid fruit volume
     * 
     * @param float $volume The invalid volume value
     * @return self Exception instance with appropriate message
     */
    public static function invalidVolume(float $volume): self
    {
        return new self("Invalid fruit volume: {$volume}. Volume must be greater than 0.");
    }

    /**
     * Create an exception for invalid fruit color
     * 
     * @param string $color The invalid color value
     * @return self Exception instance with appropriate message
     */
    public static function invalidColor(string $color): self
    {
        return new self("Invalid fruit color: {$color}. Color cannot be empty.");
    }
} 