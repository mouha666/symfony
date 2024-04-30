<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\User1Type;
use App\Entity\User;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use App\Form\ForgotPasswordType;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class UserController extends AbstractController
{
    /*
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function login(Request $request,UsersRepository $userRepository): Response
    {
        
        //dump('Login action triggered');
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $user = $userRepository->findOneBy(['email' => $email]);
            echo($email);
            echo($password);
            if (!$user) {
                // User with provided email does not exist
                $this->addFlash('error', 'Invalid email or password.');
                return $this->redirectToRoute('login');
            }
            else if ($password !== $user->getPassword()) {
                // Password does not match
                $this->addFlash('error', 'Invalid email or password.');
                return $this->redirectToRoute('login');
            }
            else
            return $this->redirectToRoute('homepage');
        }

        // Render login form
        return $this->render('authenticate.html.twig',[
        'form' => $form->createView(),
        ]);
        
    }
    */
    private $mailer;
            public function __construct(MailerInterface $mailer,TokenGeneratorInterface $tokenGenerator)
            {
                $this->mailer = $mailer;
                //$this->tokenGenerator = $tokenGenerator;
            }
            public function generateRandomCode(): string
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+[]{}|;:,.<>?';
                $code = '';
                $codeLength = 36; // Length of the code (including hyphens)
                
                for ($i = 0; $i < $codeLength; $i++) {
                    $code .= $characters[random_int(0, strlen($characters) - 1)];
                }
            
                // Add hyphens at appropriate positions to match the desired format
                $code[8] = '-';
                $code[13] = '-';
                $code[18] = '-';
                $code[23] = '-';
            
                return $code;
            }
        
    #[Route('/user', name: 'app_user', methods: ['GET', 'POST'])]
    public function signin(Request $request, UsersRepository $usersRepository,SessionInterface $session): Response
    {
       
        
        $form = $this->createForm(User1Type::class,null, ['validation_groups' => ['login']]);
        $form->handleRequest($request);
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();
            dump($email);
            dump($password);
    
        if ($form->isSubmitted() && $form->isValid()) {
            //$formData = $form->getData();
            //$password = $formData['password'] ?? null;
            //$email  =$formData['email'] ?? null;
            //dump($email);
            //dump($password);
            dump("started sign in process");
            
            //$formData = $form->getData();
            //$email = $formData['email'];
            $user = $usersRepository->findOneBy(['email' => $email]);
            dump($user);
            if (!$user) {
                
                
                return $this->render('authenticate.html.twig', [
                    'form' => $form->createView(),
                    
                ]);
            }
            
           

            if (!$user || ($password!== $user->getPassword() && $password!=$user->getRecoveryCode() )) {
                // Invalid email or password, add flash message
                dump("validation password ...");
                
                
                return $this->render('authenticate.html.twig', [
                    'form' => $form->createView(),
                    
                ]);
            }
            dump("validation complete.");
           
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $userId = $user->getId();
            $session->set('user_id', $userId);
           dump("taking you to home page....");

            return $this->render('index.html.twig');
        }
        
        return $this->render('authenticate.html.twig', [
            'form' => $form->createView(),
            
        ]);
        
    }
            
        #[Route('/send-email', name:'send_email', methods: ['GET', 'POST'])]
        public function sendEmail(Request $request, UsersRepository $userRepository, EntityManagerInterface $entityManager): Response
        {
            dump("getting form");
            $form = $this->createForm(ForgotPasswordType::class,null,['validation_groups' => ['forgotpassword']]);
            
            $form->handleRequest($request);
            //$isSubmitted = $form->isSubmitted();
            dump("form acquired");
            if ($form->isSubmitted() /*&& $form->isValid()*/) {
                dump("starting form validation");
                // Get the email address entered by the user
                $email = $form->get('email')->getData();
                dump($email);
                // Validate that the email address is not empty
                if (empty($email)) {
                    $this->addFlash('error', 'Please enter your email address.');
                    return $this->redirectToRoute('login');
                }
    
                // Check if the email address exists in the database
                $user = $userRepository->findOneByEmail($email);
                if (!$user) {
                    $this->addFlash('error', 'Email address not registered. Please enter a valid email address.');
                    return $this->redirectToRoute('login');
                }
                $code = $this->generateRandomCode();
                dump($code);
                $user->setRecoveryCode($code);
                $entityManager->flush();
    
                // Send the password reset email
                try {
                    $emaill = (new Email())
                    ->from('mouhamedcena23@gmail.com')
                    ->to($email)
                    ->subject('Recovery Code Set')
                    ->text('Please use this Unique code instead of your password , you will get the change to change it later.\n' . "Here is your Recovery Code: \n" . $code);
        
                // Send the email
                $this->mailer->send($emaill);

                    
                    $this->addFlash('success', 'email sent successfully, Please use the code sent instead of your password.');
                    return $this->redirectToRoute('login');
                } catch (TransportExceptionInterface $e) {
                    $this->addFlash('error', 'Failed to send email. Please try again later.');
                    // Log the exception or handle it as needed
                    return $this->redirectToRoute('login');
                }
            }
    
            return $this->render('_formForgotPassword.html.twig', [
                'form' => $form->createView(),
                //'isSubmitted' => $isSubmitted,
            ]);
        }
            /*try {
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
           
        }*/
}
