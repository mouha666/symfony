<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MainPageController extends AbstractController
{
    #[Route('/Home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager
        ->getRepository(Product::class)
        ->findAll();

        return $this->render('shop.html.twig', [
            'controller_name' => 'MainPageController',
            'products' => $products,
        ]);
    }
    #[Route('/subscribe', name: 'app_subscribe', methods: ['POST'])]
    public function subscribe(Request $request, MailerInterface $mailer): Response
    {
        // Get the email from the request
        $emailAddress = $request->request->get('EMAIL');

        // Create a new email message
        $email = (new Email())
            ->from('mouhamedcena23@gmail.com')
            ->to($emailAddress)
            ->subject('Subscription Confirmation')
            ->text('Thank you for subscribing!');

        // Send the email
        $mailer->send($email);

        // Redirect or render a response
        return $this->redirectToRoute('app_home', ['message' => 'Subscription successful!']);
    }
}