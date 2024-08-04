<?php

namespace App\Twig\Components;

// use App\Entity\Adherent;
use App\Repository\AdherentRepository;
use App\Service\AgeService;
use App\Service\PaginateService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class AdherentSearchFilter
{
    use DefaultActionTrait;

    // Constants
    public int $perPage = 10;

    // Dependencies
    private AdherentRepository $adherentRepository;
    private AgeService $ageService;
    private PaginateService $paginateService;

    // Configuration arrays
    public array $lvls = [
        "club",
        "departemental",
        "regional",
        "national",
        "international"
    ];  

    public array $grades = [
        "blanc",
        "blanc-jaune",
        "jaune",
        "jaune-orange",
        "orange",
        "orange-vert",
        "vert",
        "bleu",
        "marron",
        "noir"
    ];  

    public array $ageCategories = [
        "baby",
        "mini-poussin",
        "poussin",
        "benjamin",
        "minime",
        "cadet",
        "junior",
        "senior",
        "veterent"
    ];

    public array $groupesList = [
        'arbitre',
        'pole',
        'kata',
        'impaye',
        'commissaire',
        'competiteur',
        'professeur',
        'incomplet'
    ];

    // Live Properties
    // #[LiveProp(writable: true)]
    public int $page = 1;

    #[LiveProp(writable: true, url: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    public mixed $ageCategoryFilter = null;

    #[LiveProp(writable: true)]
    public mixed $gradeFilter = null;

    #[LiveProp(writable: true)]
    public mixed $arbitreFilter = null;

    #[LiveProp(writable: true)]
    public mixed $commissaireFilter = null;

    #[LiveProp(writable: true)]
    public array $groupe = [];

    #[LiveProp(writable: true)]
    public array $adherent = [];

    public array $adherentList = [];

    public int $queryCount;

    public array $filter = [
        'grade' => false,
        'yearRange' => false,
        'arbitre' => false,
        'commissaire' => false,
        'groupe' => false,
    ];

    // Constructor
    public function __construct(
        AdherentRepository $adherentRepository,
        AgeService $ageService,
        PaginateService $paginateService
    ) {
        $this->adherentRepository = $adherentRepository;
        $this->ageService = $ageService;
        $this->paginateService = $paginateService;
    }


    public function mount()
    {
        $this->filter = [
            'grade' => $this->gradeFilter,
            'yearRange' => strlen($this->ageCategoryFilter) > 0 ? $this->ageService->getAgeByCategorie($this->ageCategoryFilter) : [],
            'arbitre' => $this->arbitreFilter,
            'commissaire' => $this->commissaireFilter,
            'groupe' => count($this->groupe) ? $this->groupe : false,
        ];
        $this->adherentList = $this->adherentRepository->searchIndex('', $this->filter, 1, 10);
        // dd($this->adherentList, "mount",$this->adherentRepository->searchIndex('', $this->filter, 1, 10),$this->adherentRepository->searchIndex('', $this->filter));
        // $this->adherentList = $this->adherentRepository->searchIndex('', $this->filter, 1, $this->perPage);
    }


    // Methods
    public function getQuery(): string
    {

        $this->getQueryCount();
        // $this->applyFilters();
        return $this->query;
        
    }
    public function getPerPage(): string
    {
        

        // $this->applyFilters();
        return $this->perPage;
        
    }

    public function getQueryCount(): int
    {
        $this->queryCount = strlen($this->query);
        // $this->applyFilters();
        return $this->queryCount;
        
    }

    public function getGradeFilter(): mixed
    {
        return $this->gradeFilter;
        
    }


    public function getAgeCategoryFilter(): mixed
    {
        // $this->applyFilters();
        return $this->ageCategoryFilter;
        
    }

    public function getArbitreFilter(): mixed
    {
        // $this->applyFilters();
        return $this->arbitreFilter;
        
    }

    public function getCommissaireFilter(): mixed
    {   
        // $this->page = 1;
        // $this->applyFilters();
        return $this->commissaireFilter;
        
    }

    // #[LiveAction]
    // public function nextPage(): void
    // {
    //     ++$this->page;
    // }

    public function getHasMore(): bool
    {
        return count($this->adherentList) > ($this->page * $this->perPage);
    }



    #[LiveAction]
    public function applyFilters(): void
    {
        $this->filter = [
            'grade' => $this->gradeFilter,
            'yearRange' => strlen($this->ageCategoryFilter) > 0 ? $this->ageService->getAgeByCategorie($this->ageCategoryFilter) : [],
            'arbitre' => $this->arbitreFilter,
            'commissaire' => $this->commissaireFilter,
            'groupe' => count($this->groupe) ? $this->groupe : false,
        ];
        // dd($this->query);
        $this->page = 1; // Reset to first page when filters change
        $this->adherentList = $this->adherentRepository->searchIndex($this->query, $this->filter);
        // dd($this->adherentList);
    }

    // #[LiveAction]
    // public function nextPage(): void
    // {
    //     // if ($this->getHasMore()) {
    //         $this->page = $this->page + 1;
    //         $this->applyFilters();
    //     // }
    // }

    public function getAdherents(): array
    {
        // $offset = ($this->page - 1) * $this->perPage;
        // $adherent = array_slice($this->adherentList, $offset, $this->perPage);
        // dd($this->adherentList);
        return $this->adherentList;
    }

    // public function getHasMore(): bool
    // {
    //     $total = count($this->adherentList);
    //     return $total > ($this->page * $this->perPage);
    // }
}
