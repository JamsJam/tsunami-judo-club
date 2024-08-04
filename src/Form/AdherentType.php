<?php

namespace App\Form;

use App\Entity\Adherent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdherentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid')
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('nom')
            ->add('prenom')
            ->add('birthAt', null, [
                'widget' => 'single_text',
            ])
            ->add('sexe')
            ->add('address1')
            ->add('adress2')
            ->add('adress3')
            ->add('ville')
            ->add('cpo')
            ->add('pays')
            ->add('indicatifPays')
            ->add('telephone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}
