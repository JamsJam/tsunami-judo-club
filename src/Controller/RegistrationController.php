<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\Contacturgence;
use App\Security\EmailVerifier;
use App\Form\ContacturgenceType;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use App\Repository\AdherentRepository;
use App\Form\Register\RegisterStep1Type;
use App\Form\Register\RegisterStep2Type;
use App\Form\Register\RegisterStep4Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // $user = new Adherent();
        $session = $request->getSession();
        $form = $this->createForm(RegisterStep1Type::class);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            // dd('sudmitted');
            $session->set('infoPerso', $form->getData()); 
            
            return $this->redirectToRoute('app_register_part2');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }


    #[Route('/inscription/part2', name: 'app_register_part2')]
    public function registerPart2(Request $request): Response
    {
        $session = $request->getSession();
        
        // if(is_null($session->get('infoPerso')) ){
        //     return $this->redirectToRoute('app_register');
        // }



        $form = $this->createForm(RegisterStep2Type::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $session = $request->getSession();
            $session->set('infoContact', $form->getData()); 


            return $this->redirectToRoute('app_register_part3');
        }

        return $this->render('registration/registerStep2.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/inscription/part3', name: 'app_register_part3')]
    public function registerPart3(Request $request): Response
    {
        $session = $request->getSession();
        // dd($session->get('infoPerso'),$session->get('infoContact'));
        if(is_null($session->get('infoPerso'))|| is_null($session->get('infoContact'))){
            return $this->redirectToRoute('app_register');
        }



        $form = $this->createForm(ContacturgenceType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $session = $request->getSession();
            $session->set('infoContactUrgence', $form->getData()); 


            return $this->redirectToRoute('app_register_part4');
        }

        return $this->render('registration/registerStep3.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/inscription/part4', name: 'app_register_part4')]
    public function registerPart4(Request $request,UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        // dd($session->get('infoPerso'),$session->get('infoContact'));
        if(is_null($session->get('infoPerso'))|| is_null($session->get('infoContact'))|| is_null($session->get('infoContactUrgence'))){
            return $this->redirectToRoute('app_register');
        }



        $form = $this->createForm(RegisterStep4Type::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $session = $request->getSession();
            $session->set('infoContactUrgence', $form->getData()); 
            
            //todo =================== resolve form and set new user
            $user = new Adherent;
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('mailer@example.com', 'AcmeMailBot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            //todo ===================
            return $this->redirectToRoute('app_main');
        }

        return $this->render('registration/registerStep4.html.twig', [
            'registrationForm' => $form,
        ]);
    }


    // #[Route('/register/step_{step}', name: 'app_register_step', requirements:["step"=>"\d+"])]
    // public function registerStep(int $step, Request $request, EntityManagerInterface $entityManager): Response
    // {
        

        

    //     if ($form->isSubmitted() && $form->isValid()) {
            
    //         return $this->redirectToRoute('app_home');
    //     }

        
    //     return $this->render('registration/register.html.twig', [
    //         'registrationForm' => $form,

    //     ]);
    // }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, AdherentRepository $adherentRepository): Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $adherentRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
