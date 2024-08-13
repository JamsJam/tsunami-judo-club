<?php
namespace App\Twig\Components\Calendar;

use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class DayComponent
{
    use ComponentToolsTrait;
    use DefaultActionTrait;

    public array $day;
    public array $todayEvent = [];

    public function mount(array $day, ?string $todayEvent = null): void
    {
        $this->day = $day;
        $this->todayEvent = $todayEvent ? json_decode($todayEvent, true) : [];
    }

    #[LiveListener('eventArray')]
    public function getEvent(#[LiveArg('evenement')] mixed $event): void
    {
         // Assign the received event data
        dd($event); // Debugging: this should show the event data
    }

}

