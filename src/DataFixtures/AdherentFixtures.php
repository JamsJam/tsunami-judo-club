<?php

namespace App\DataFixtures;

use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Licence;
use App\Entity\Adherent;
use App\Repository\GradeRepository;
use App\Repository\LicenceRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ArbitrelvlRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\CommissairelvlRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class AdherentFixtures extends Fixture
{
    private readonly UserPasswordHasherInterface $hasher ;
    private GradeRepository $gr;
    private ArbitrelvlRepository $ar;
    private CommissairelvlRepository $cr;
    // private UuidV7 $uuid;

    public function __construct(
        UserPasswordHasherInterface $hasher, 
        GradeRepository $gr,
        ArbitrelvlRepository $ar,
        CommissairelvlRepository $cr,
        // UuidV7 $uuid

    )
    {
        $this->hasher = $hasher ;
        $this->gr = $gr ;
        $this->ar = $ar ;
        $this->cr = $cr ;
        // $this->uuid = $uuid ;
    }



    public function load(ObjectManager $manager): void
    {


        $faker = Factory::create('fr_FR');
        $allGrades = $this->gr->findAll();
        $allArbitreLv = $this->ar->findAll() ;
        $allCommissaireLv = $this->cr->findAll();

        for ($i=0; $i < 50; $i++) { 

            $uuid = Uuid::v7();

            $adherent = new Adherent();
            $adherent
                    ->setUuid($uuid->generate())
                    ->setSexe(random_int(0,1))
                    ->setNom($faker->lastName())
                    ->setPrenom($adherent->getSexe() === 0 ? $faker->firstNameMale() : $faker->firstNameFemale())
                    ->setBirthAt(new DateTimeImmutable($faker->dateTimeBetween('-50 Years', '-13 Years')->format('Y-m-d')))
                    ->setEmail($faker->email())
                    ->setPassword($this->hasher->hashPassword($adherent, 'password'))
                    ->setTelephone(intval($faker->phoneNumber()))
                    ->setAdress1($faker->streetAddress())
                    ->setCpo('971' . random_int(0,9) . random_int(0,9))
                    ->setCreatedAt(new DateTimeImmutable('now'))
                    ->setUpdatedAt(new DateTimeImmutable('now'))
                ;
            $manager->persist($adherent);
                
            $licence = new Licence();
            $licence->setAdherent($adherent)
                    ->setNumero($this->getLicenceNumber($adherent))
                    ->setCreatedAt(new DateTimeImmutable('now'))
                    ->setUpdatedAt(new DateTimeImmutable('now'))
                    ->setRenewedAt(new DateTimeImmutable('now'))
                    ->setGrade($allGrades[array_rand($allGrades, 1)])
                    ->setArbitrelvl($allArbitreLv[array_rand($allArbitreLv, 1)])
                    ->setCommissairelvl($allCommissaireLv[array_rand($allCommissaireLv, 1)])
            ;
            $manager->persist($licence);
                

            
            $manager->flush();
        }

    }


    /**
     * retourne le numero de licence a partir des information de l'adherent
     * @param Adherent $a
     * @param LicenceRepository $lr
     * @return String
     * 
     */
    public function getLicenceNumber(Adherent $a): String
    {

        $a->getSexe() == 0 ? $sex = 'M' : $sex = 'F';
        $dnd = $a->getBirthAt()->format('dmY');
        
        if(strlen($a->getNom()) >= 5){
            $name = mb_strtoupper(substr($a->getNom(),0,5 )) ;
        }else{
            $name = mb_strtoupper($a->getNom() . str_repeat('*',(5 - strlen($a->getNom()) ) ) );

        }
         return $nbLicenceBase = $sex . $dnd . $this->removeAccents($name) . '0' . random_int(1,5) ;


        
    }

    public function removeAccents(String $str) {
        $unwanted_array = array(
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a', 'ā' => 'a', 'ă' => 'a', 'ą' => 'a',
            'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
            'î' => 'i', 'ï' => 'i', 'í' => 'i', 'ī' => 'i', 'ĩ' => 'i', 'į' => 'i', 'ĭ' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'ơ' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ū' => 'u', 'ŭ' => 'u', 'ů' => 'u', 'ű' => 'u', 'ų' => 'u', 'ư' => 'u',
            'ý' => 'y', 'ÿ' => 'y', 'ŷ' => 'y',
            'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
            'ß' => 'ss',
            'Æ' => 'AE', 'æ' => 'ae', 'Ø' => 'O', 'ø' => 'o',
            'œ' => 'oe', 'Œ' => 'OE',
            // majuscules
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Ã' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ă' => 'A', 'Ą' => 'A',
            'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E', 'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E',
            'Î' => 'I', 'Ï' => 'I', 'Í' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Į' => 'I', 'Ĭ' => 'I',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Ö' => 'O', 'Õ' => 'O', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O', 'Ơ' => 'O',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ū' => 'U', 'Ŭ' => 'U', 'Ů' => 'U', 'Ű' => 'U', 'Ų' => 'U', 'Ư' => 'U',
            'Ý' => 'Y', 'Ÿ' => 'Y', 'Ŷ' => 'Y',
            'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N',
        );
    
        return strtr($str, $unwanted_array);
    }
}
