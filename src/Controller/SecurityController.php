<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function jsonLogin(): Response
    {
        $user = $this->getUser();
       if($user  instanceof User){

           $response = new JsonResponse( [
               
               'email'=>$user->getEmail(),
               'roles' => $user->getRoles()

      ] );
      return $response;
    }
    $response = new JsonResponse([
        'ok'=>false,
        'msg'=> "not found User" 
    ]);
    return $response;
    }
}
