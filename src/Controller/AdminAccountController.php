<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('admin/account/login.html.twig', [
            'hasError' => $error != null,
            'username' => $username
        ]);
    }

    /**
     * Permet à l'admin de se déconnecter
     * 
     * @Route("/admin/logout", name="admin_account_logout")
     *
     * @return void
     */
    public function logout()
    {
    }

    /**
     * Affiche et traite le formulaire de modification de profil 
     *
     * @Route("/admin/account/profile/{slug}", name="admin_account_profile")
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
                "Le profile de {$user->getFullName()}  a bien été modifié"
            );

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/account/profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
