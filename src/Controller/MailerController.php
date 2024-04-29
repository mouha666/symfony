<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    
        private $mailer;

        public function __construct(MailerInterface $mailer)
        {
            $this->mailer = $mailer;
        }
    
        
          #[Route('/send-email', name:'send_email')]
         
        public function sendEmail(): Response
        {
            try {
                // Create a new email message
                $email = (new Email())
                    ->from('mouhamedcena23@gmail.com')
                    ->to('avocadopi3000@gmail.com')
                    ->subject('Test Email')
                    ->text('This is a test email.');
        
                // Send the email
                $this->mailer->send($email);
        
                return new Response('Email sent successfully');
            } catch (TransportExceptionInterface $e) {
                // Log the exception or handle it as needed
                return new Response('Error sending email: ' . $e->getMessage());
            }
           
        }
        
    
}
