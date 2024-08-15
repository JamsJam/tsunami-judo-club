<?php

namespace App\Twig\Components\Home;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Hero
{
    private array $homeInfo = [
        'header' => [
            'h1' => 'LE TSUNAMI CLUB : PLUS QU’UN DOJO, UNE ECOLE DE VIE',
            // 'h2' => 'Notre club et ses valeurs',
            'description' => 'Le judo enseigne la discipline, le respect et la persévérance. Au-delà des techniques, il forge l\'esprit et le caractère. Chaque judoka apprend l\'humilité et le courage, cultivant l\'entraide et la maîtrise de soi. Au Tsunami Club, le judo est une école de vie transformant ses pratiquants.',
            // 'ctaPrim' => [
            //     'path' => 'app_register',
            //     'text' => 'Prenez votre licence',
            // ],
            'ctaSec' => [
                'path' => 'app_front_about',
                'text' => 'A propos du club',
                'id'   => 'club'
                
            ],
        ],
        'horraire' => [
            'h2' => 'Des entrainement adaptés pour tous ',
            'description' => 'Le tsunami club propose des cours poour tous les ages, du plus petits au plus grands',
            'ctaSec' => [
                'path' => 'app_front_contact',
                'text' => 'Horaires',
                'id'   => 'horaire'
            ],
        ],
        'discipline' => [
            'h2' => 'Une pratique variée',
            'description' => 'Au-dela du judo, nous proposons plusieur disciplines associés afin d’etre au plus proche de vos objectifs',
            'ctaSec' => [
                'path' => 'app_front_about',
                'text' => 'Nos disciplines',
                'id'   => 'discipline'
            ],
        ],
        'evenement' => [
            'h2' => 'Un club  de Judo dynamique',
            'description' => 'Que ça soit en terme de competition, de stage ou de formation, le tsunami club participe et organise de nombreux evenements',
            'ctaSec' => [
                'path' => 'app_front_calendar',
                'text' => 'Nos evenements'
            ],
        ],
        'contact' => [
            'h2' => 'Un contact facilité et privilegié',
            'description' => 'Une question sur le judo ou notre club ? Contactez nous',
            'ctaSec' => [
                'path' => 'app_front_contact',
                'text' => 'Contactez-nous',
                'id'   => 'contact'
            ],
        ],
        'inscription' => [
            'h2' => 'Rejoignez nous Dés maintenant ',
            // 'description' => 'Description pour la page 6',
            // 'ctaPrim' => [
            //     'path' => 'app_register',
            //     'text' => 'Prenez votre licence',
            // ],
        ],
    ];
    
    public string $key='contact';


    public string $message = 'jrke';




    
    /**
     * getHomeTile
     *
     * @return array
     */
    public function getHomeTile():array
    {
        // dd($this->key);
        return $this->homeInfo[$this->key];
    }
}
