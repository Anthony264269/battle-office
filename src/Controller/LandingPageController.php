<?php

namespace App\Controller;

use App\Entity\Order;
use Stripe\Stripe;
use stripe\Checkout\Session;
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
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LandingPageController extends AbstractController
{
  #[Route('/', name: 'landing_page')]
  public function index(Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
  {
    $order = new Order;
    $products = $productRepository->findAll();


    $form = $this->createForm(OrderType::class, $order);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $productId = $form->getExtraData()['cart']['cart_products'][0];
      $product = $productRepository->findOneBy(['id' => $productId]);

      $shipping = $form->get('shipping')->getData();
      $shipping->setFirstName($order->getFirstName());
      $shipping->setLastName($order->getLastName());
      $shipping->setAdress($order->getAdress());


      if ($order->getAdditionnalAdress()) {
        $shipping->setAdditionnalAdress($order->getAdditionnalAdress());
      }
      $shipping->setCity($order->getCity());
      $shipping->setCountry($order->getCountry());
      $shipping->setPhone($order->getPhone());
      $shipping->setZipcode($order->getZipcode());

      $order->setCreatedAt(new DateTimeImmutable());
      $order->setProduct($product);

      $entityManager->persist($order);
      $entityManager->flush();
      // dd($order);
      $this->api($order);
      $this->stripeCheckout($order);
      $this->redirectToRoute('stripe_checkout', ['id' => $order->getId()]);
    }

    return $this->render('landing_page/index_new.html.twig', [
      'form' => $form->createView(),
      'products' => $products,

    ]);
  }


  #[Route('/confirmation', name: 'confirmation')]
  public function confirmation(): Response
  {

    return $this->render('landing_page/confirmation.html.twig', []);
  }

  #[Route('/cancel', name: 'cancel')]
  public function cancel(): Response
  {

    return $this->render('landing_page/confirmation.html.twig', []);
  }



  public function api($order)
  {
    // dd($order);
    $client = new \GuzzleHttp\Client();

    $result = $client->request('POST', 'https://api-commerce.simplon-roanne.com/order', [
      'headers' => [
        'Authorization' => 'Bearer mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX'
      ], // Informations d'authentification
      // Données de la commande
      'json' => [
        'order' => [
          'id' => 1,
          'product' => $order->getProduct()->getModel(),
          'payment_method' => 'stripe',
          'status' => 'WAITING',
          'client' => [
            'firstname' => $order->getFirstName(),
            'lastname' => $order->getLastName(),
            'email' => $order->getEmail()
          ],
          "addresses" => [
            "billing" => [
              "address_line1" => $order->getShipping()->getAdress(),
              "address_line2" => $order->getShipping()->getAdditionnalAdress(),
              "city" => $order->getShipping()->getCity(),
              "zipcode" => $order->getShipping()->getZipCode(),
              "country" => $order->getShipping()->getCountry()->getName(),
              "phone" => $order->getShipping()->getPhone()
            ],
            "shipping" => [
              "address_line1" => $order->getShipping()->getAdress(),
              "address_line2" => $order->getShipping()->getAdditionnalAdress(),
              "city" => $order->getShipping()->getCity(),
              "zipcode" => $order->getShipping()->getCity(),
              "country" => $order->getShipping()->getCountry()->getName(),
              "phone" => $order->getShipping()->getPhone()
            ]
          ]
        ]
      ]
    ]);
  }

  #[Route('/stripe/checkout/{id}', name: 'stripe_checkout')]
    public function stripeCheckout(Order $order): RedirectResponse {
        $stripe = new StripeClient($_ENV['STRIPE_SECRET_KEY']);
        $checkout_session = $stripe->checkout->sessions->create([
            'customer_email' => $order->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $order->getProduct()->getModel(),
                    ],
                    'unit_amount' => $order->getProduct()->getPrice(),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('confirmation', ['id' => $order->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);

        return new RedirectResponse($checkout_session->url);
    }

}


    
      // public function __construct(readonly private string $clientSecret)
      // {
      //   $tripe::setApiKey($this->clientSecret);

      //   $tripe::setApiVersion('2023-10-16');
      // }

      // public function startPayement(Cart $cart){
      //   $session = Session::create([

      //     'mode' => 'payement',
      //     'success_url' => 'htpp://localhost:8000/success.php'
      //   ]);
      // }
