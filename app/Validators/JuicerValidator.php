<?php

namespace App\Validators;

use App\Models\Fruit;
use App\Models\Apple;
use App\Exceptions\JuicerException;

class JuicerValidator
{
    /**
     * Validates juicer component capacity
     *
     * @param float $capacity
     * @throws JuicerException
     */
    public static function validateCapacity(float $capacity): void
    {
        if ($capacity <= 0) {
            throw JuicerException::invalidCapacity($capacity);
        }
    }

    /**
     * Validates container space for new fruit
     *
     * @param float $newVolume
     * @param float $capacity
     * @throws JuicerException
     */
    public static function validateContainerSpace(float $newVolume, float $capacity): void
    {
        if ($newVolume > $capacity) {
            throw JuicerException::containerFull($capacity);
        }
    }

    /**
     * Validates fruit for juicing
     *
     * @param Fruit $fruit
     * @throws JuicerException
     */
    public static function validateForJuicing(Fruit $fruit): void
    {
        if ($fruit instanceof Apple && $fruit->isRotten()) {
            throw JuicerException::rottenFruit();
        }
    }
} 