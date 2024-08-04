<?php

Namespace App\Service;

use DateTimeImmutable;


class AgeService
{


    private $today ;

    public function __construct(DateTimeImmutable $today = new DateTimeImmutable('now') ) {
        $this->today = $today;
    }

    private function getReferenceAge(DateTimeImmutable $dnd) :int
    {
        $annee = $this->today->format('Y');

        
        if( 
            $this->today >= new DateTimeImmutable((intval($annee)) . '-01-01') && 
            $this->today < new DateTimeImmutable( $annee . '-08-01') 
        ){
            $ageDeReference = intval($dnd->diff( (new DateTimeImmutable((intval($annee)) . '-12-31')) )->format('%y')) ;

        }elseif (
            $this->today < new DateTimeImmutable((intval($annee) + 1) . '-01-01') && 
            $this->today >= new DateTimeImmutable($annee . '-08-01') 
        ) {
            $ageDeReference = intval($dnd->diff( (new DateTimeImmutable((intval($annee) + 1) . '-12-31')) )->format('%y')) ;
        }

        return $ageDeReference;
    }
   
    public function getAge(DateTimeImmutable $dnd ): int
    {

        $age = $dnd->diff($this->today) ;

        return intval($age->format('%y'));
    }

    public function getAgeCategorie( DateTimeImmutable $dnd): String
    {
        
        $age = $this->getReferenceAge($dnd);
        
        return $this->determineCategory($age);

    }

    public function getAgeByCategorie( string $category): array
    {
        
        $rangeAge = $this->determineAge($category);
        $yearRange = $this->getYearofBirth($rangeAge);

        return $yearRange;

    }

 
    private function determineCategory(int $age) : string 
    {
        switch (true) {
            case ($age < 6):
                return 'baby';
            case ($age < 8):
                return 'Mini-poussin';
            case ($age == 8):
                return 'Poussin 1';
            case ($age == 9):
                return 'Poussin 2';
            case ($age == 10):
                return 'Benjamin 1';
            case ($age == 11):
                return 'Benjamin 2';
            case ($age == 12):
                return 'Minime 1';
            case ($age == 13):
                return 'Minime 2';
            case ($age == 14):
                return 'Cadet 1';
            case ($age == 15):
                return 'Cadet 2';
            case ($age == 16):
                return 'Cadet 3';
            case ($age == 17):
                return 'Junior 1';
            case ($age == 18):
                return 'Junior 2';
            case ($age == 19):
                return 'Junior 3';
            case ($age < 30):
                return 'Senior';
            default:
                return 'Vétérant';
        
        };
    }
    
    private function determineAge(string $categorie) : array
    {
        switch ($categorie) {
            case 'baby':
                return range(0,5);  // Plage d'âge pour les tout petits
            case 'mini-poussin':
                return range(6,7);  // Plage d'âge pour Mini-poussin
            case 'poussin':
                return range(8,9);    // Âge exact pour Poussin 1 
            case 'benjamin':
                return range(10, 11);   // Âge exact pour Benjamin 1
            case 'minime':
                return range(12, 13);   // Âge exact pour Minime 1
            case 'cadet':
                return range(14, 16);   // Âge exact pour Cadet 1
            case 'junior':
                return range(17,19);   // Âge exact pour Junior 1
            case 'senior':
                return range(20, 29);  // Plage d'âge pour Senior
            case 'veterent':
                return range(30, 999);    // Plage d'âge pour Vétérant et au-delà
        }
    }

    private function getYearofBirth(array $ageRange) :array
    {

        $annee = $this->today->format('Y');

        // dd($ageRange);

        if( 
            $this->today >= new DateTimeImmutable((intval($annee)) . '-01-01') && 
            $this->today < new DateTimeImmutable( $annee . '-08-01') 
        ){
            // $yearRange = intval($dnd->diff( (new DateTimeImmutable((intval($annee)) . '-12-31')) )->format('%y')) ;

            $yearRange = range($annee - $ageRange[0], $annee - end($ageRange));

        }elseif (
            $this->today < new DateTimeImmutable((intval($annee) + 1) . '-01-01') && 
            $this->today >= new DateTimeImmutable($annee . '-08-01') 
        ) {
            // $ageDeReference = intval($dnd->diff( (new DateTimeImmutable((intval($annee) + 1) . '-12-31')) )->format('%y')) ;
            $yearRange = range($annee - $ageRange[0] + 1 , $annee - end($ageRange) + 1 );
        }

        return $yearRange;
    }





}