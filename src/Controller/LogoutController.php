<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function index(SessionInterface $session): Response
    {
        $session->invalidate();
        //dump($session);
        return $this->redirectToRoute('login');
    }
}
