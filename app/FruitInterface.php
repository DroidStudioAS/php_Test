<?php

namespace App;

interface FruitInterface
{
    public function getColor(): string;
    public function getVolumne(): float;
    public function toString(): string;
}