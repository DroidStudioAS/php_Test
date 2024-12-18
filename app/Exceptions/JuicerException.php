<?php

namespace App\Exceptions;

use Exception;

/**
 * Class JuicerException
 * 
 * Exception class for handling juicer-related errors.
 * Provides specific exception messages for different juicer operation failures.
 * 
 * @package App\Exceptions
 */
class JuicerException extends Exception
{
    /**
     * Create an exception for when container is full
     * 
     * @param float $capacity The maximum capacity that was exceeded
     * @return self Exception instance with appropriate message
     */
    public static function containerFull(float $capacity): self
    {
        return new self("Container is full. Maximum capacity is {$capacity}L");
    }

    /**
     * Create an exception for invalid capacity value
     * 
     * @param float $capacity The invalid capacity value
     * @return self Exception instance with appropriate message
     */
    public static function invalidCapacity(float $capacity): self
    {
        return new self("Invalid capacity: {$capacity}. Capacity must be greater than 0.");
    }

    /**
     * Create an exception for attempting to juice rotten fruit
     * 
     * @return self Exception instance with appropriate message
     */
    public static function rottenFruit(): self
    {
        return new self("Cannot juice rotten fruit.");
    }
} 