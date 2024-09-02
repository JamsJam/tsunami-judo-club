<?php

namespace App\Form\Register;

use App\Entity\Adherent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('adress1',TextType::class,[
            'required' => false,
            'attr'=>[
                'class'=>'input__text'
            ]
        ])
        // ->add('adress2')
        // ->add('adress3')
        ->add('ville',TextType::class,[
            'required' => false,
            'attr'=>[
                'class'=>'input__text'
            ]
        ])
        ->add('cpo',TextType::class,[
            'required' => false,
            'attr'=>[
                'class'=>'input__text'
            ]
        ])
        ->add('pays',TextType::class,[
            'required' => false,
            'attr'=>[
                'class'=>'input__text'
            ]
        ])
        // ->add('indicatifPays')
        ->add('telephone',TextType::class,[
            'required' => false,
            'attr'=>[
                'class'=>'input__text'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Adherent::class,
        ]);
    }
}
