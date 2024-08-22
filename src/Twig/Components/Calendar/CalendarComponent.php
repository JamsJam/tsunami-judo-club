<?php

namespace App\Twig\Components\Calendar;

use App\Entity\Event;
use App\Repository\EventRepository;
use DateTimeImmutable;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;


#[AsLiveComponent]
final class CalendarComponent
{
    private EventRepository $eventRepository ;


    public  function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    #[LiveProp(writable:true)]
    public string $today ;
    
    #[LiveProp(writable:true)]
    public mixed $beginCalendar = null;
    
    #[LiveProp(writable:true)]
    public mixed $endCalendar= null;

    // #[LiveProp(writable:true)]
    public ?string $years;
    
    // #[LiveProp(writable:true)]
    public ?string $month;

    #[LiveProp(writable:true)]
    public array $days = [];


    // #[LiveProp(writable:true,useSerializerForHydration: true)]
    // /**
    //  * Undocumented variable
    //  *
    //  */
    // public  array $events = [];



    public function mount(){
        $this->today = (new DateTimeImmutable('now'))->format('Y-m-d') ;
        // $this->events = [['titre'=> 'titre', 'beginAt' => $this->today]];
    }


    public function getEvents(){
        // return $this->dehydrateEvents($this->events);
        return $this->eventRepository->calendarEvent(
            new DateTimeImmutable($this->beginCalendar),
            new DateTimeImmutable($this->endCalendar)
        );

    }







    use DefaultActionTrait;
}
