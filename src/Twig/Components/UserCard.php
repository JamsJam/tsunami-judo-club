<?php

namespace App\Twig\Components;

use App\Service\AgeService;
use DateTimeImmutable;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;



#[AsTwigComponent]
final class UserCard
{
    private AgeService $ageService;
    
    public function __construct(AgeService $ageService) {
        $this->ageService = $ageService;
    }

    //auto binding avec le template

    public string $nom = 'nom default';
    
    public string $prenom;

    public string $ageCategory;
    
    public string $id = "0190b30a-4ad9-7e9a-836b-eee308db47a3";
    
    public int $age;

    public string $grade;
    
    
    public String $numero;
    // public String $nom;

    // public String $categorie_age = $this->getCategorieAge($age);


    // mout() execute des fonction avant renderinf
    public function mount( DateTimeImmutable $dnd ){

        $this->age = $this->ageService->getAge($dnd);

        $this->ageCategory = $this->ageService->getAgeCategorie($dnd);
        
    }


}
    

