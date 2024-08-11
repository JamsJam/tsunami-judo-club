<?php
namespace App\Twig\Components\Calendar;

use DateTimeImmutable;
use App\Repository\EventRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class CalendarComponent
{
    use ComponentToolsTrait;
    use DefaultActionTrait;

    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    #[LiveProp(writable: true)]
    public string $today;

    #[LiveProp(writable: true)]
    public mixed $beginCalendar = null;

    #[LiveProp(writable: true)]
    public mixed $endCalendar = null;

    #[LiveProp(writable: true)]
    public array $days = [];

    public function mount(): void
    {
        $this->today = (new DateTimeImmutable('now'))->format('d-m-Y');
    }

    #[LiveAction]
    public function getEvents(): array
    {
        $intervalEvent = $this->eventRepository->calendarEvent(
            new DateTimeImmutable($this->beginCalendar),
            new DateTimeImmutable($this->endCalendar)
        );

        $finalTable = array_map([$this, 'isAllDayEvent'], $intervalEvent);

        // Emit the event with the finalTable data
        $this->emitEvent($finalTable);

        return $finalTable;
    }

    #[LiveAction]
    public function emitEvent(mixed $events): void
    {
        // Emit the event with data to be captured by DayComponent
        // dd($events);
        $this->emit('eventArray',[
            'evenement' => $events
        ]);
    }
    

    public function isAllDayEvent(array $eventItem): array
    {
        return [
            'titre' => $eventItem['titre'],
            'beginAt' => $eventItem['beginAt'],
            'endAt' => $eventItem['endAt'],
            'allday' => is_null($eventItem['endAt']),
        ];
    }
}
