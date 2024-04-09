<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front/utilisateur")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/ajouter", name="app_front_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ["custom_option" => "new"]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $user->getPassword();
            $hashPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashPassword);

            $userRepository->add($user, true);

            $this->addFlash("success", "Compte ajouté, vous pouvez maintenant vous connecter - Pour tester un compte \"manager\" veuillez me contacter à : contact@iannarelli.fr");

            return $this->redirectToRoute('app_security_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // /**
    //  * @Route("/{id}", name="app_front_user_show", methods={"GET"})
    //  */
    // public function show(User $user): Response
    // {
    //     return $this->render('front/user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/editer", name="app_front_user_edit", methods={"GET", "POST"})
    //  */
    // public function edit(Request $request, User $user, UserRepository $userRepository): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
            
    //         $userRepository->add($user, true);

    //         return $this->redirectToRoute('app_main_home', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('front/user/edit.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }

}
