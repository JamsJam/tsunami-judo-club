<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Licence;
use App\Entity\Eventstype;
use Symfony\Component\Uid\Uuid;
use App\Entity\Participationtype;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UuidType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    //         ->add('uuid')
    //         ->add('createdAt', null, [
    //             'widget' => 'single_text',
    //         ])
    //         ->add('editedAt', null, [
    //             'widget' => 'single_text',
    //         ])
    //         ->add('beginAt', null, [
    //             'widget' => 'single_text',
    //         ])
    //         ->add('endAt', null, [
    //             'widget' => 'single_text',
    //         ])
    //         ->add('titre')
    //         ->add('description')
    //         ->add('isPublic')
    //         ->add('invite', EntityType::class, [
    //             'class' => Licence::class,
    //             'choice_label' => 'id',
    //             'multiple' => true,
    //         ])
    //         ->add('type', EntityType::class, [
    //             'class' => Eventstype::class,
    //             'choice_label' => 'id',
    //         ])
    //         ->add('need', EntityType::class, [
    //             'class' => Participationtype::class,
    //             'choice_label' => 'id',
    //             'multiple' => true,
    //         ])
    //     ;
    // }
    // ->add('uuid', UuidType::class, [
    //     'label' => 'UUID',
    //     'required' => true,
    //     'data' => Uuid::v7(),
    // ])
    // ->add('createdAt', DateTimeType::class, [
    //     'label' => 'Created At',
    //     'widget' => 'single_text',
    // ])
    // ->add('editedAt', DateTimeType::class, [
    //     'label' => 'Edited At',
    //     'widget' => 'single_text',
    // ])

    ->add('beginAt', DateTimeType::class, [
        'label' => 'Begin At',
        // 'widget' => 'single_text',
    ])
    ->add('endAt', DateTimeType::class, [
        'label' => 'End At',
        // 'widget' => 'single_text',
    ])
    ->add('titre', TextType::class, [
        'label' => 'Title',
        "attr" =>[
            'class' => 'input__text'
        ]
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            "attr" =>[
                'class' => 'input__text'
            ]
    ])
    ->add('isPublic', CheckboxType::class, [
        'label' => 'Is Public?',
        'required' => false,
    ])

    
    //todo Option avancé : rappel, invitation, besoin a faire pour la V2  
    // ->add('invite', EntityType::class, [
    //     'class' => Licence::class,
    //     'label' => 'Invite',
    //     'multiple' => true,
    //     'choice_label' => 'numero', // Remplacez 'name' par le champ approprié
    // ])
    // ->add('type', EntityType::class, [
    //     'class' => Eventstype::class,
    //     'label' => 'Event Type',
    //     'choice_label' => 'nom', // Remplacez 'name' par le champ approprié
    // ])
    // ->add('participations', EntityType::class, [
    //     'class' => Participationtype::class,
    //     'label' => 'Participations',
    //     'multiple' => true,
    //     'choice_label' => 'nom', // Remplacez 'name' par le champ approprié
    // ])
    // ->add('need', EntityType::class, [
    //     'class' => Participationtype::class,
    //     'label' => 'Needs',
    //     'multiple' => true,
    //     'choice_label' => 'nom', // Remplacez 'name' par le champ approprié
    // ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
