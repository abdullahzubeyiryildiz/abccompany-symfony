<?php
namespace App\Controller;
 
use Symfony\Component\Routing\Annotation\Route; 
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class AuthController extends AbstractController
{
    /**
     * @Route("/api/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);
        $encodedPassword = $encoder->encodePassword($user, $data['password']);
        $user->setPassword($encodedPassword);

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'User registered successfully'], JsonResponse::HTTP_CREATED);
    }
 

    /**
     * @Route("/api/login", name="login", methods={"POST"})
     */
    public function login(Request $request, UserProviderInterface $userProvider, UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];
         
        $user = $userProvider->loadUserByUsername($email);
 
        if (!$user || !$encoder->isPasswordValid($user, $password)) {
            throw new BadCredentialsException('Invalid email or password');
        }
         
        $token = $jwtManager->create($user);
         
        return new JsonResponse(['token' => $token,'message'=>'Login Success',]);
    }


    /**
     * @Route("/api/some-protected-route", name="protected_route", methods={"GET"})
     */
    public function protectedRoute(): JsonResponse
    {
        // Burada korumalı rotaya ait işlemleri gerçekleştirin
        // Örnek olarak, korumalı bir veriye erişim veya bir işlem yapabilirsiniz

        return new JsonResponse(['message' => 'Protected Route Accessed']);
    }

}