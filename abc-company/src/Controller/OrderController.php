<?php 
namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Repository\OrderRepository;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use \Exception;

/**
 * @Route("/api/orders")  
 * @IsGranted("ROLE_USER")
 */
class OrderController extends AbstractController
{
    const ORDER_PREFIX = 'ORD-';
    /**
     * @Route("", name="order_create", methods={"POST"})
     */
    public function create(Request $request,EntityManagerInterface $entityManager): Response
    { 
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();
      
        try{
            is_user_auth($user);
        }catch(Exception $err){ 
            throw $err;
        }

        $order = new Order();
        $orderCode = self::ORDER_PREFIX . time();
        $order->setOrderCode($orderCode); 
        $order->setUser($user); 

        $productId = $data['productId'];
        $product = $entityManager->getRepository(Product::class)->find($productId);
        $order->setProduct($product); 

        if(isset($data['address'])){
            $order->setAddress($data['address']);  
        } 
   
         $order->setQuantity($data['quantity'] ?? 1); 
       
   
        if(isset($data['shippingDate'])) {
            $order->setShippingDate(new \DateTime($data['shippingDate']));
        }
     
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->json($order, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{order_no}", name="order_update", methods={"PUT"})
     */
    public function update(Request $request, OrderRepository $orderRepository, $order_no, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->getUser();
        try{
            is_user_auth($user);
        }catch(Exception $err){ 
            throw $err;
        }

        
        $order = $orderRepository->findOneBy(['orderCode' => $order_no]);
    
        if (!$order) {
            return new Response('Order not found.', Response::HTTP_NOT_FOUND);
        }
        
        if (empty($order->getShippingDate())) {
            $shippingDate = new \DateTime($data['shippingDate']);
            $order->setShippingDate($shippingDate);
            if(isset($data['address'])) {
                $order->setAddress($data['address']);
            }
 
            if(isset($data['productId']) && !empty($data['productId'])) {
                $productId = $data['productId'];
                $product = $entityManager->getRepository(Product::class)->find($productId);
                $order->setProduct($product); 
            }
          
            if(isset($data['quantity']) && !empty($data['quantity'])) {
                $order->setQuantity($data['quantity']);
            }
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
    
            return $this->json($order);
        }else{
            return new Response('Order could not be updated, reason : already shipped', Response::HTTP_BAD_REQUEST);
        }
    
        return new Response('Update operation could not be completed.', Response::HTTP_BAD_REQUEST);
    }

   /**
     * @Route("/{order_no}", name="order_show", methods={"GET"})
     */
    public function show(OrderRepository $orderRepository, $order_no): Response
    {
        $user = $this->getUser();
        try{
            is_user_auth($user);
        }catch(Exception $err){ 
            throw $err;
        }

        if(empty($order_no)) {
            return new Response('Order No Empty.', Response::HTTP_NOT_FOUND);
        }

        $order = $orderRepository->findOneBy(['orderCode' => $order_no]);

        if (!$order) {
            return new Response('Order not found.', Response::HTTP_NOT_FOUND);
        }

        return $this->json($order);
    }

    /**
     * @Route("", name="order_list", methods={"GET"})
     */
    public function index(UserInterface $user): Response
    {
        
        $orders = $this->getDoctrine()->getRepository(Order::class)->findBy(['user' => $user]);

        return $this->json($orders);
    }
 
}