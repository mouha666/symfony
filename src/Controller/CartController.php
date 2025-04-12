<?php
namespace App\Controller;

use App\Entity\Product;
use App\Entity\Command;
use App\Entity\CommandProduct;
use App\Repository\CommandProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
public function index(SessionInterface $session, ProductRepository $productRepository): Response 
{
    $panier = $session->get('panier', []);
    $products = [];

    foreach ($panier as $id => $quantity) {
        $product = $productRepository->find($id);
        if ($product) {
            $products[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->getPrice() * $quantity
            ];
        }
    }

    $total = array_sum(array_column($products, 'subtotal'));

    return $this->render('cart.html.twig', [
        'products' => $products,
        'total' => $total
    ]);
}


    #[Route('/add/{id}', name: 'app_addtocart')]
    public function add(Product $product, SessionInterface $session): Response
    {
        $id = $product->getId();
        $panier = $session->get('panier', []);

        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_home');
    }

    #[Route('/remove/{id}', name: 'app_removefromcart')]
public function remove(Product $product, SessionInterface $session): Response
{
    $panier = $session->get('panier', []);
    $id = $product->getId();

    if (isset($panier[$id])) {
        if ($panier[$id] > 1) {
            // Decrease the quantity
            $panier[$id]--;
        } else {
            // Remove the item from the cart if the quantity is 1
            unset($panier[$id]);
        }
    }

    $session->set('panier', $panier);

    return $this->redirectToRoute('app_cart');
}


#[Route('/checkout', name: 'app_checkout', methods: ['POST'])]
public function checkout(SessionInterface $session, EntityManagerInterface $entityManager, Request $request): Response
{
    $panier = $session->get('panier', []);

    if (empty($panier)) {
        $this->addFlash('error', 'Your cart is empty.');
        return $this->redirectToRoute('app_cart');
    }

    $recaptchaResponse = $request->request->get('g-recaptcha-response');
    
    if (!$recaptchaResponse) {
        $this->addFlash('error', 'Please confirm you are not a robot.');
        return $this->redirectToRoute('app_cart');
    }

    // Create a new Command entity
    $command = new Command();
    $command->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));

    // Persist the Command entity
    $entityManager->persist($command);

    foreach ($panier as $id => $quantity) {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            continue; // Skip if product not found
        }

        // Add the product to the command
        $this->addProductToCommand($command, $product, $quantity, $entityManager);
    }

    // Flush the changes to the database
    $entityManager->flush();

    // Clear the cart
    $session->set('panier', []);

    // Redirect to the home page or success page
    return $this->redirectToRoute('app_home');
}



public function addProductToCommand(Command $command, Product $product, int $quantity, EntityManagerInterface $entityManager): void
{
    $commandProduct = $entityManager->getRepository(CommandProduct::class)->findOneBy([
        'command' => $command,
        'product' => $product
    ]);

    if ($commandProduct) {
        // Update quantity if it already exists
        $commandProduct->setQuantity($commandProduct->getQuantity() + $quantity);
    } else {
        // Create a new CommandProduct entry
        $commandProduct = new CommandProduct();
        $commandProduct->setCommand($command);
        $commandProduct->setProduct($product);
        $commandProduct->setQuantity($quantity);
        $entityManager->persist($commandProduct);
    }

    $entityManager->flush();
}
#[Route('/export-to-excel', name: 'export_to_excel')]
public function exportToExcel(CommandProductRepository $cpRepository): Response
{
    dump("function started");
    
    $cps = $cpRepository->findAll();

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Get the active sheet
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers
    $sheet->setCellValue('A1', 'Command ID');
    $sheet->setCellValue('B1', 'Product Name');
    $sheet->setCellValue('C1', 'Quantity');
    $sheet->setCellValue('D1', 'Price');

    // Set row counter
    $row = 2;

    
    foreach ($cps as $cp) {
        $sheet->setCellValue('A' . $row, $cp->getCommand());
        $sheet->setCellValue('B' . $row, $cp->getProduct()->getName());
        $sheet->setCellValue('C' . $row, $cp->getQuantity());
        $sheet->setCellValue('D' . $row, $cp->getQuantity() * $cp->getProduct()->getPrice());

        // Increment row counter
        $row++;
    }

    // Create a new Excel writer object
    $writer = new Xlsx($spreadsheet);

    // Create temporary file path
    $tempFilePath = tempnam(sys_get_temp_dir(), 'excel_');

    // Save the Excel file to temporary location
    $writer->save($tempFilePath);

    // Return the Excel file as a response
    return $this->file($tempFilePath, 'Command.xlsx');
}
}
