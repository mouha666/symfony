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
    #[Route('/user', name: 'app_user', methods: ['GET', 'POST'])]
    public function signin(Request $request, UsersRepository $usersRepository): Response
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
            
           

            if (!$user || $password!== $user->getPassword() ) {
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

           dump("taking you to home page....");

            return $this->render('index.html.twig');
        }
        
        return $this->render('authenticate.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
}
