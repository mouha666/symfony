<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UsersRepository;
use App\Form\UserProfileType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;


class ProfileManagerController extends AbstractController
{
    #[Route('/profile/manager', name: 'app_profile_manager')]
    public function index(SessionInterface $session,UsersRepository $userRepository): Response
    {
        $userId = $session->get('user_id');
        dump($userId);

        $user = $userRepository->find($userId);

        $form = $this->createForm(UserProfileType::class, $user);

        if ($form->isSubmitted()){
            $this->UserManager($user,$form->getData());
        }

        return $this->render('profile.html.twig', [
            'controller_name' => 'ProfileManagerController',
            'form' => $form->createView(),
        ]);
    }
    public function UserManager(User $user, $formData)
    {
        if ($user->getPassword() !== $formData['password']) {
        $user->setPassword($formData['password']);

        // Persist the changes to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        }
    }
}
