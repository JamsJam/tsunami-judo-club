<?php
namespace App\Twig\Components\Calendar;

use DateTimeImmutable;
use Symfony\Component\Uid\UuidV7;
use App\Repository\EventRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;


#[AsLiveComponent]
final class DayComponent
{
    use ComponentToolsTrait;
    use DefaultActionTrait;


    private EventRepository $eventRepository ;


    public  function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    #[LiveProp(writable:true)]
    public string $uniqid;


    #[LiveProp(writable:true)]
    public string $date;
    
    
    #[LiveProp(writable:true)]
    public int $dateNumber;
    
    #[LiveProp(writable:true)]
    public mixed $beginCalendar = null;
    
    #[LiveProp(writable:true)]
    public mixed $endCalendar= null;
    
    
    
    // #[LiveProp(writable: true, hydrateWith: 'hydrateTodayEvents', dehydrateWith: 'dehydrateTodayEvents')]
    // public array $todayEvents = [];
    
    public array $long = [];

    public array $ponctuel = [];

    public array $allDay = [];





    //* =========== Initialize

    public function mount(string $date): void
    {
        $this->date = $date;
        $this->dateNumber = 0;
        // $this->todayEvents = [];
        $this->uniqid = UuidV7::generate();
        // dd($this->uniqid);
        $this->fetchEventOfTheDay($this->date);
    }

    //* ======================






    //* =========== Hydration methods 

        
    public function hydrateTodayEvents(array $data): array
    {
        // Custom logic to hydrate (convert) the incoming array data into the desired format
        return $data;
    }

    public function hydrateLong(string $long): void
    {
        $this->long = json_decode($long, true);
    }

    public function hydratePonctuel(string $ponctuel): void
    {
        $this->ponctuel = json_decode($ponctuel, true);
    }

    public function hydrateAllDay(string $allDay): void
    {
        $this->allDay = json_decode($allDay, true);
    }

    public function dehydrateTodayEvents(array $todayEvents): array
    {
        // Custom logic to dehydrate (convert) the data into a simple array format
        return $todayEvents;
    }


    //* ======================






    //* =========== Dehydration methods 

    public function dehydrateLong(): string
    {
        return json_encode($this->long);
    }

    public function dehydratePonctuel(): string
    {
        return json_encode($this->ponctuel);
    }

    public function dehydrateAllDay(): string
    {
        return json_encode($this->allDay);
    }

    //* ====================== 





    //* =========== LiveAction

    #[LiveAction]
    public function fetchEventOfTheDay( 
        string $date, 
        array $newLongArray = [], 
        array $newAllDayArray = [], 
        array $newPonctuelArray = []
    ){

        // dd($date, $datetime);
        
        $todayEvents = $this->eventRepository->getEventOfTheDay(
            new DateTimeImmutable($date),
        );

        // count( $todayEvents) > 0 && dd($todayEvents[0]);
        if( count( $todayEvents) > 0 ){

        
            foreach ($todayEvents as $event) {
                
                try{
                    switch (true) {
                        case is_null($event["endAt"]) && $event["nom"] !== 'anniversaire':
                            array_push($newAllDayArray,$event);
                            break;
                            
                        case $event["endAt"] === $event["beginAt"] || $event["nom"] === 'anniversaire':
                            array_push($newPonctuelArray,$event);
                            break;
                            
                        case $event["endAt"] !== $event["beginAt"]:
                            array_push($newLongArray, $event);
                            break;
                            
                        default:
                            throw new \Exception('The event ' . $event['titre'] .' is unclassifiable.');
                        break;
                    }
                }catch (\Exception $e) {
                    // Handle the exception, e.g., log it or display an error message
                    echo" ". $e->getMessage();
                }

            }
            // dd($newLongArray, $newPonctuelArray, $newAllDayArray);
            $this->updateEvents($newLongArray, $newPonctuelArray, $newAllDayArray);
        }
    }
    
    #[LiveAction]
    public function updateEvents(array $newLong, array $newPonctuel, array $newAllDay): void
    {
        // dd($newLong,$newPonctuel,$newAllDay);

        $this->long = $newLong;
        $this->ponctuel = $newPonctuel;
        $this->allDay = $newAllDay;
        // dd($this->long,$this->ponctuel,$this->allDay);
    }


    //* ====================== 




    //* =========== LiveListener
    
    
    #[LiveListener('eventArray')]
    public function getEvent(#[LiveArg('evenement')] mixed $event): void
    {
        // Assign the received event data
        dd($event); // Debugging: this should show the event data
    }
    
    



    //* ======================



    //* =========== Getter

    // public function getLong(): array
    // {
    //     return $this->long;
    // }

    // public function getPonctuel(): array
    // {
    //     return $this->ponctuel;
    // }

    // public function getAllDay(): array
    // {
    //     return $this->allDay;
    // }

    //* ======================


    //* =========== Helper
    
    public function isAllDayEvent(array $eventItem) :array
    {
        return  [
            'titre' => $eventItem['titre'],
            'beginAt' => $eventItem['beginAt'],
            'endAt' => $eventItem['endAt'],
            'allday' => is_null($eventItem['endAt']),
        ];
    }


    public function sortEvent(array $event, ){
        // switch de tri allday, long and ponctuel event

        switch (true) {
            case is_null($event["endAt"]):
                # code...
                break;
            
            case $event["endAt"] === $event["BeginAt"] || $event["nom"] === 'anniversaire':
                # code...
                break;
            
            case $event["endAt"] !== $event["BeginAt"]:
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }
    //* ======================
}

