<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Adherent as User;
use App\Entity\Event;
use App\Entity\EventsType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(

    name: 'event:create-user-birthday',
    description: 'Crée des événements pour les anniversaires pour l\'année en cour des utilisateurs',
)]
class CreateUserBirthdayEventCommand extends Command
{

    private $entityManager;

    
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
            ->setDescription('Crée des événements pour les anniversaires des utilisateurs');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);
        $userRepository = $this->entityManager->getRepository(User::class);
        $eventRepository = $this->entityManager->getRepository(Event::class);
        $eventTypeRepository = $this->entityManager->getRepository(EventsType::class);

        $users = $userRepository->findAll();
        $currentYear = (new \DateTime())->format('Y');
        $eventType = $eventTypeRepository->findOneBy(['id'=>2]);

        foreach ($users as $user) {
            $birthday = $user->getBirthAt();
            $birthdayThisYear = (clone $birthday)->setDate($currentYear, $birthday->format('m'), $birthday->format('d'));

            // Vérifiez si l'événement existe déjà pour éviter les doublons
            $existingEvent = $eventRepository->findOneBy([
                'type' => $eventType,
                'beginAt' => $birthdayThisYear,
                'titre' => 'Anniversaire de ' . $user->getPrenom() .' '. $user->getNom()

            ]);

            if (!$existingEvent) {
                $event = (new Event())
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setEditedAt(new \DateTimeImmutable())
                    ->setTitre('Anniversaire de ' . $user->getPrenom() .' '. $user->getNom())
                    ->setType($eventType)
                    ->setBeginAt($birthdayThisYear)
                    ->setDescription('Anniversaire de ' . $user->getPrenom() .' '. $user->getNom() );

                    $event->setPublic(false);

                $this->entityManager->persist($event);
            }
        }

        $this->entityManager->flush();

        $io->success('Les événements d\'anniversaire de cette année ont été créés avec succès.');

        return Command::SUCCESS;
    }
}
