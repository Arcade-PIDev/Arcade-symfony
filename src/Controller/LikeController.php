<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Blog;


class LikeController extends AbstractController
{
    #[Route('/like/blog/{id}', name:'app_like')]
    public function Like(Blog $blog, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if($blog->isLikedByUser($user))
        {
            $blog->removeLike($user);
            $manager->flush();
            return $this->json(['message'=>'Le Like a ete supprimé.']);
        }
        $blog->addLike($user);
        $manager->flush();
        return $this->json(['message'=>'Le Like a ete ajouté.']);
    }

}