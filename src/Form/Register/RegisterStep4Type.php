<?php

namespace App\Form\Register;

use App\Entity\Grade;
use App\Entity\Adherent;
use App\Entity\Arbitrelvl;
use App\Entity\Commissairelvl;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterStep4Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('uuid')
            ->add('isNewbi', ChoiceType::class, [

                'label'=>'Avez-vous deja pratiqué le judo dans ce club ?',
                'attr' => [
                    'data-update-register-target' => 'radios'
                ],
                'mapped' => false,
                "expanded"  => true,
                "multiple"  => false,
                'choices' => [
                    'oui' => true,
                    'non' => false
                ]

            ])
            ->add('email',EmailType::class,[
                'required'=>false,
                'attr'=>[
                    'class'=>'input__text'
                ]

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => [
                    'attr' => [
                        'class' => 'input__text',
                        'autocomplete' => 'new-password'
                    ]
                ],
                'first_options'  => [
                    'label' => 'Password'
                ],
                'second_options' => [
                    'label' => 'Repeat Password'
                ],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                ])
                // ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) :void
                // {
                //     $form = $event->getForm();

                //     // this would be your entity, i.e. SportMeetup
                //     $data = $event->getData();
    
                //     // $isNewbi = $data->get('isNewbi');
                    
                //     // dd($data);
                //     dd( $data);
                //     if(isset($isNewbi) && false === $isNewbi){
                //         $form
                //             ->add('licence')
                //             ->add('arbitreLvl')
                //             ->add('commissairelvl')
                //             ->add('grade')
                //             ;
                //     }
    
                // })
                // ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) :void
                // {
                //     $form = $event->getForm();

                //     // this would be your entity, i.e. SportMeetup
                //     $data = $event->getData();
    
                //     // $isNewbi = $data->get('isNewbi');
                    
                //     dd($data,$form,$event);
                //     // dd($event);
                //     if(isset($isNewbi) && false === $isNewbi){
                //         $form
                //             ->add('licence')
                //             ->add('arbitreLvl')
                //             ->add('commissairelvl')
                //             ->add('grade')
                //             ;
                //     }
    
                // })
            ;
                // Handle form modifications based on initial data
                $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
                    $data = $event->getData();
                    $form = $event->getForm();

                    // dd($data['isNewbi'],isset($data['isNewbi']) && $data['isNewbi'] == 1);
                    if (isset($data['isNewbi']) && $data['isNewbi'] == 1) {
                        $form
                            ->add('licence',TextType::class,[
                                'required'=>false,
                                'attr'=>[
                                    'class'=>'input__text',
                                    
                                ],
                                'row_attr'=> [
                                    'id'=> "licence"
                                ]
                            ])
                            ->add('arbitreLvl',EntityType::class,[
                                'class' => Arbitrelvl::class,
                                'choice_label' => 'niveaux',
                                'multiple'=>false,
                                'expanded'=> false,
                                'mapped'=>false,
                                'row_attr'=> [
                                    'id'=> "arbitrelvl"
                                ]
                            ])
                            ->add('commissairelvl',EntityType::class,[
                                'class' => Commissairelvl::class,
                                'choice_label' => 'niveaux',
                                'multiple'=>false,
                                'expanded'=> false,
                                'mapped'=>false,
                                'row_attr'=> [
                                    'id'=> "commissairelvl"
                                ]
                            ])
                            ->add('grade',EntityType::class,[
                                'class' => Grade::class,
                                'choice_label' => function ($grade){
                                    $grade->getCeinture() === 'noir' ? $label =  $grade->getGrade() : $label = $grade->getCeinture() ;
                                    return $label ;
                                } ,
                                'multiple'=>false,
                                'expanded'=> false,
                                'mapped'=>false,
                                'row_attr'=> [
                                    'id'=> "grade"
                                ]
                            ]);
                    }
                });
        
                // Handle form modifications based on submitted data
                // $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
                //     $data = $event->getData();
                //     $form = $event->getForm();
                //     
                //     if (isset($data['isNewbi']) && $data['isNewbi'] === false) {
                //         $form
                //             ->add('licence')
                //             ->add('arbitreLvl')
                //             ->add('commissairelvl')
                //             ->add('grade');
                //     }
                // });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Adherent::class,
        ]);
    }
}
