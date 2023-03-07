<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Blog;
use App\Entity\Comment;
use App\Form\BlogFormType;
use App\Repository\BlogRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Comment1Type;
use DateTimeImmutable;

class LikeController extends AbstractController
{
    #[Route('/like/blog/{id}', name: 'app_like')]
    public function Like(Blog $blog, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if($blog->isLikedByUser($user))
        {
            $blog->removeLike($user);
            $manager->flush();
            return $this->redirectToRoute('app_home');        }
        $blog->addLike($user);
        $manager->flush();
return $this->redirectToRoute('app_home');    }

}