<?php

namespace App\Validators;

use App\Exceptions\FruitException;

/**
 * Class FruitValidator
 * 
 * Provides validation methods for fruit properties.
 * Ensures that fruits are created with valid attributes.
 * 
 * @package App\Validators
 */
class FruitValidator
{
    /**
     * Validates fruit properties
     * 
     * Ensures that the fruit has valid color and volume values.
     * Color must not be empty and volume must be positive.
     *
     * @param string $color  The color to validate
     * @param float  $volume The volume to validate
     * @throws FruitException When color is empty or volume is not positive
     */
    public static function validate(string $color, float $volume): void
    {
        if (empty($color)) {
            throw FruitException::invalidColor($color);
        }

        if ($volume <= 0) {
            throw FruitException::invalidVolume($volume);
        }
    }

    /**
     * Validates apple-specific properties
     * 
     * Extends basic fruit validation with apple-specific checks.
     * Ensures that the rotten state is a valid boolean value.
     *
     * @param string $color    The color to validate
     * @param float  $volume   The volume to validate
     * @param bool   $isRotten The rotten state to validate
     * @throws FruitException When validation fails for any property
     */
    public static function validateApple(string $color, float $volume, ?bool $isRotten): void
    {
        self::validate($color, $volume);

        if (!is_bool($isRotten)) {
            throw FruitException::invalidRottenState();
        }
    }
} 