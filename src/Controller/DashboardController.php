<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\CommandProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Gedmo\Sluggable\Util\Urlizer;
use App\Form\CommandType;

class DashboardController extends AbstractController
{
    #[Route('/dash', name: 'app_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager
        ->getRepository(Product::class)
        ->findAll();

        return $this->render('dashindex.html.twig', [
            'controller_name' => 'DashboardController',
            'products' => $products,
        ]);
    }
    #[Route('/{id}/show', name: 'app_auth_edit', methods: ['GET', 'POST'])]
    public function show(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        
        $product = $entityManager->getRepository(Product::class)->find($id);
    
        
    
        // Create and handle the form
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $uploadedfile = $form->get('imageFile')->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/assets/images';
            $originalFilename = pathinfo($uploadedfile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename ="/shop/public/assets/images/".$originalFilename.'.'.$uploadedfile->guessExtension();
            $product->setImage($newFilename);
            $entityManager->persist($product);
            $entityManager->flush();
    
            // Redirect back to the client show page
            return $this->redirectToRoute('app_dashboard');
        }
    
        return $this->render('showproduct.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            
        ]);
    }
    #[Route('/add', name: 'app_dash_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $brochureFile */
             $uploadedfile = $form->get('imageFile')->getData();
             $destination = $this->getParameter('kernel.project_dir').'/public/assets/images';
             $originalFilename = pathinfo($uploadedfile->getClientOriginalName(), PATHINFO_FILENAME);
             $newFilename ="/shop/public/assets/images/".$originalFilename.'.'.$uploadedfile->guessExtension();
             $product->setImage($newFilename);
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('addproduct.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    #[Route('/dashCommand', name: 'app_dashboard_Command')]
    public function indexCommand(EntityManagerInterface $entityManager): Response
    {
        $commands = $entityManager
        ->getRepository(Command::class)
        ->findAll();

        return $this->render('dashcommandindex.html.twig', [
            'controller_name' => 'DashboardController',
            'commands' => $commands,
        ]);
    }
    #[Route('/addCommand', name: 'app_dash_add_command', methods: ['GET', 'POST'])]
    public function addcommand(Request $request, EntityManagerInterface $entityManager): Response
    {
        $command = new Command();
        
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             
            $entityManager->persist($command);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard_Command', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('addcommand.html.twig', [
            'command' => $command,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: 'app_product_delete', methods: ['POST'])]
public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
{
    $product = $entityManager->getRepository(Product::class)->find($id);

    if ($product) {
        $entityManager->remove($product);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_dashboard');
}
#[Route('/{id}/showC', name: 'app_auth_edit_command', methods: ['GET', 'POST'])]
    public function showCommand(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        
        $command = $entityManager->getRepository(Command::class)->find($id);
    
        
    
        // Create and handle the form
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($command);
            $entityManager->flush();
    
            // Redirect back to the client show page
            return $this->redirectToRoute('app_dashboard_Command');
        }
    
        return $this->render('showproduct.html.twig', [
            'product' => $command,
            'form' => $form->createView(),
            
        ]);
    }
    #[Route('/{id}/deletec', name: 'app_command_delete', methods: ['POST'])]
public function deleteC(Request $request, EntityManagerInterface $entityManager, int $id): Response
{
    $command = $entityManager->getRepository(Command::class)->find($id);

    if ($command) {
        $entityManager->remove($command);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_dashboard_Command');
}
#[Route('/dashcp', name: 'app_dashboard_cp')]
    public function indexCP(EntityManagerInterface $entityManager): Response
    {
        $cp = $entityManager
        ->getRepository(CommandProduct::class)
        ->findAll();

        return $this->render('dashcommandproducts.html.twig', [
            'controller_name' => 'DashboardController',
            'cps' => $cp,
        ]);
    }

}
