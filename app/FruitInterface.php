<?php

namespace App;

interface FruitInterface
{
    public function getColor(): string;
    public function getVolume(): float;
    public function toString(): string;
    public function getJuiceAmount(): float;
}