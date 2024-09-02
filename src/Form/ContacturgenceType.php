<?php

namespace App\Form;

use App\Entity\Licence;
use App\Entity\Contacturgence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContacturgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required'=>false,
                'attr'=>[
                    'class'=>'input__text'
                ]
            ])
            ->add('prenom',TextType::class,[
                'required'=>false,
                'attr'=>[
                    'class'=>'input__text'
                ]
            ])
            ->add('telephone',TextType::class,[
                'required'=>false,
                'attr'=>[
                    'class'=>'input__text'
                ]
            ])
            // ->add('licence', EntityType::class, [
            //     'class' => Licence::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacturgence::class,
        ]);
    }
}
