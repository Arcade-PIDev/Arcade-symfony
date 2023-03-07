<?php

namespace App\Controller;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\BlogRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(BlogRepository $blogRepository, Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $address=$form->get('email')->getData();
            $objet=$form->get('objet')->getData();
            $content=$form->get('content')->getData();
            
            $email = (new Email())
                ->from($address)
                ->to('ghada.eladeb@esprit.tn')
                ->subject($objet)
                ->text($content);

            $mailer->send($email);
        }
        

        return $this->renderForm('home/index.html.twig', [
            'controller_name'=>'HomeController',
            'form' => $form,
            'Blogs' => $blogRepository->findAll()
        ]);
    }
}
