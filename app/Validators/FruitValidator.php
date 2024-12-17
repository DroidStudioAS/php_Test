<?php

namespace App\Validators;

use App\Exceptions\FruitException;

class FruitValidator
{
    /**
     * Validates fruit properties
     *
     * @param string $color
     * @param float $volume
     * @throws FruitException
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
     * @param string $color
     * @param float $volume
     * @param bool|null $isRotten
     * @throws FruitException
     */
    public static function validateApple(string $color, float $volume, ?bool $isRotten): void
    {
        self::validate($color, $volume);

        if (!is_bool($isRotten)) {
            throw FruitException::invalidRottenState();
        }
    }
} 