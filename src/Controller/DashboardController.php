<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;

class DashboardController extends AbstractController
{
    #[Route('/dash', name: 'app_dash')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
        ->getRepository(User::class)
        ->findAll();

        return $this->render('dashIndex.html.twig', [
            'controller_name' => 'DashboardController',
            'users' => $users,
        ]);
    }
}
