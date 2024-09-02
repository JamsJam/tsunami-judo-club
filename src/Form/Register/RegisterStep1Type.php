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
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required'=>false,
                'attr' => [
                    'class' => 'input__text'
                ]
            ])

            ->add('prenom',TextType::class,[
                'required'=>false,
                'attr' => [
                    'class' => 'input__text'
                ]
            ])

            ->add('birthAt', BirthdayType::class, [
                'required'=>false,
                'label'=>"Date d'anniversaire",
                'attr' => [
                    'placeholder' => 'jj / mm / aaaa', // indique le format attendu
                    'class' => 'input__text'
                ],
            
                'placeholder'   =>  'jj/mm/aaaa',
                'widget'        =>  'single_text',
                'input'         =>  'string',
                // 'format'        =>  'dd-MM-yyyy',
                // 'html5'         =>  false,
                // 'input_format'  =>  'd-m-Y'
                "mapped"   => false
            ])

            ->add('sexe', ChoiceType::class,[
                'required'=>false,
                'label'=> false,
                'choices'   => [
                    'Homme' => 1,
                    'Femme' => 2,
                ],
                "expanded"  => true,
                "multiple"  => false
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
