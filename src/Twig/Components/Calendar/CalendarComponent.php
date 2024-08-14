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


    // #[LiveProp( hydrateWith: 'hydrateEvents', dehydrateWith: 'dehydrateEvents')]
    /**
     * Undocumented variable
     *
    //  * @var Event[]
     */
    // public ?Event $events = null;



    public function mount(){
        $this->today = (new DateTimeImmutable('now'))->format('d-m-Y') ;
        // $this->events = [['titre'=> 'titre', 'beginAt' => $this->today]];
    }


    public function getEvents(){
        // return $this->dehydrateEvents($this->events);
        return $this->eventRepository->calendarEvent(
            new DateTimeImmutable($this->beginCalendar),
            new DateTimeImmutable($this->endCalendar)
        );

    }

    // public function dehydrateEvents(Event $event)
    // {
    //     dd('deshydrate');
    //     return [
    //         'titre' => $event->getTitre(),
    //         'beginAt' => $event->getBeginAt()->format('dd-mm-YYY'),
    //         'endAt' => $event->getEndAt()?->format('dd-mm-YYY'),
    //         'allDay' => is_null($event->getEndAt())
    //     ];
    // }

    // public function hydrateEvents($data): Event
    // {
    //     $event = new Event();
    //     $event->setTitre($data['titre']);
    //     $event->setBeginAt(new DateTimeImmutable($data['start']));
    //     if ($data['end']) {
    //         $event->setEndAt(new DateTimeImmutable($data['end']));
    //     }
    //     // Vous pouvez ajouter les autres propriétés ici

    //     return $event;
    // }


    #[LiveAction]
    public function fetchEvent(){
        // dd($this->beginCalendar,$this->endCalendar);
        $events = $this->eventRepository->calendarEvent(
            new DateTimeImmutable($this->beginCalendar),
            new DateTimeImmutable($this->endCalendar)
        );
          $result = array_map([$this, 'isAllDayEvent'], $events);
        
          
        // dd($this->events);
        
    }

    public function isAllDayEvent(array $eventItem) :array
    {
        
            // $item['allday'] = is_null($item['endAt']);
        return  [
            'titre' => $eventItem['titre'],
            'beginAt' => $eventItem['beginAt'],
            'endAt' => $eventItem['endAt'],
            // 'type' => $eventItem['type'],
            'allday' => is_null($eventItem['endAt']),
            ];
    }




    use DefaultActionTrait;
}
