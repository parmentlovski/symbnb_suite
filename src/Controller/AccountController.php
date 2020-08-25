<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Service\MailerService;
use App\Form\PasswordUpdateType;
use App\Repository\UserRepository;
use App\Form\PasswordForgottenType;
use App\Form\ResettingType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\AuthenticityAccountService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class AccountController extends AbstractController
{
    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error != null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     *
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {
    }

    /**
     * Affiche le formulaire d'inscription
     *
     * @Route("/register", name="account_register")
     * 
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé !'
            );

            return $this->redirectToRoute("account_login");
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Affiche et traite le formulaire de modification de profil 
     *
     * @Route("/account/profile/{slug}", name="account_profile")
     * @IsGranted("ROLE_USER")
     * 
     * 
     * @return Response
     */
    public function profile(User $user, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre profil a bien été modifié'
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier le mot de passe
     * 
     * @Route("/account/password-update", name="account_password")
     * @IsGranted("ROLE_USER")
     * 
     * @param Request $request
     * @return Response
     */
    public function updatePassword(Request $request, EntityManagerInterface $manager,  UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $passwordUpdate->getoldPassword();

            // Vérifions si le oldPassword du formulaire soit le même que le password de user
            if (!$encoder->isPasswordValid($user, $oldPassword)) {
                // Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été modifié'
                );

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la liste des réservations faites par l'utilisateur
     * 
     * @Route("/account/bookings", name="account_bookings")
     *
     * @return Response
     */
    public function bookings()
    {
        return $this->render('account/bookings.html.twig');
    }

    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     * 
     * @Route("/account/{slug}", name="account_index")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function myAccount(User $user)
    {
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * Permet de recréer un mot de passe
     * 
     * TODO: trouver une solution pour avoir cette URL "/account/passwordForgotten" sans rentrer en conflit avec la route "account_index"
     * @Route("/passwordForgotten", name="account_passwordForgotten")
     *
     * @return Response
     */
    public function passwordForgotten(Request $request, UserRepository $userRepo, AuthenticityAccountService $authenticityAccountService, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager, MailerService $mailer)
    {

        $form = $this->createForm(PasswordForgottenType::class);

        $form->handleRequest($request);

        $user = $userRepo->loadUserByUsername($form->getData()['email']);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form['email']->getData());
            if ($authenticityAccountService->checkEmail($form['email']->getData()) == true) {
                // dump("Vrai");

                // création du token
                $user->setToken($tokenGenerator->generateToken());
                // enregistrement de la date de création du token
                $user->setPasswordRequestedAt(new \Datetime());
                $manager->flush();

                // on utilise le service Mailer créé précédemment
                $bodyMail = $mailer->createBodyMail('account/mail.html.twig', [
                    'user' => $user
                ]);
                $mailer->sendMessage('from@email.com', $user->getEmail(), 'renouvellement du mot de passe', $bodyMail);
                $this->addFlash(
                    'success',
                    "Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h."
                );

                return $this->redirectToRoute("account_login");
            } else {
                $this->addFlash(
                    'danger',
                    "Adresse mail invalide"
                );
            }
        }

        return $this->render('account/passwordForgotten.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // si supérieur à 10min, retourne false
    // sinon retourne false
    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null) {
            return false;
        }

        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 10;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }

    /**
     * @Route("/account_resetting/{id}/{token}", name="resetting")
     */
    public function resetting(User $user, $token, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // interdit l'accès à la page si:
        // le token associé au membre est null
        // le token enregistré en base et le token présent dans l'url ne sont pas égaux
        // le token date de plus de 10 minutes
        if ($user->getToken() === null || $token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt())) {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(ResettingType::class, $user);
        $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        //     $user->setHash($password);

        //     // réinitialisation du token à null pour qu'il ne soit plus réutilisable
        //     $user->setToken(null);
        //     $user->setPasswordRequestedAt(null);

        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($user);
        //     $em->flush();

        //     $request->getSession()->getFlashBag()->add('success', "Votre mot de passe a été renouvelé.");

        //     return $this->redirectToRoute('connexion');
        // }

        return $this->render('resetting/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
