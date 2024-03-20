<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LandingPageController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order;
        
        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $shipping = $form->get('shipping')->getData();
            $shipping->setFirstName($order->getFirstName());
            $shipping->setLastName($order->getLastName());
            $shipping->setAdress($order->getAdress());
            if($order->getAdditionnalAdress()) {
                $shipping->setAdditionalAdress($order->getAdditionnalAdress());
            }
            $shipping->setCity($order->getCity());
            $shipping->setCountry($order->getCountry());
            $shipping->setPhone($order->getPhone());
            $shipping->setZipcode($order->getZipcode());

            $order->setCreatedAt(new DateTimeImmutable());
            $entityManager->persist($order);
            $entityManager->flush();
        }

        return $this->render('landing_page/index_new.html.twig', [
            'form' => $form->createView()
       
    ]); 
   
        
        
    }

    #[Route('/confirmation', name: 'confirmation')]
    public function confirmation(): Response
    {
    
        return $this->render('landing_page/confirmation.html.twig', []);
    }
}