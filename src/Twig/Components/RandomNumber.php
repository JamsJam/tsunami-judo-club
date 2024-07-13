<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class RandomNumber
{
    #[LiveProp(writable: true)]
    public int $max = 1000;

    public function getRandomNumber(): int
    {
        return rand(0, $this->max);
    }
    use DefaultActionTrait;
};
