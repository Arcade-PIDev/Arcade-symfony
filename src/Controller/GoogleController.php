<?php
namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    #[Route('/connect/google', name:'connect_google')]

// @return \Symfony\Component\Httpfoundation\RedirectResponse

public function connectAction (ClientRegistry $clientRegistry)
{
return $clientRegistry
    ->getClient ('google')
    ->redirect();
}

#[Route('/connect/google/check', name: 'connect_google_check')]

// @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse

public function connectCheckAction (Request $request)
{
        if (!$this->getUser()) {
        return new JsonResponse(array('status' => false, 'message' => "User not found!"));
        } else {
        return $this->redirectToRoute('dashboard');}
}
}