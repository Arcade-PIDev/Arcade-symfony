<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Repository\EvenementRepository;
use App\Entity\Evenement;

class NotifController extends AbstractController
{

    #[Route('/notif/{id}', name: 'app_notif')]
    public function home(FlashyNotifier $flashy, EvenementRepository $repo,$id)
    {
        $flashy->success("Cet Evenement commence aujourd'hui !", 'http://your-awesome-link.com');
        return $this->render('notif/index.html.twig', [
            'listEvents' => $repo->findById($id),
        ]);
    }

   
}
