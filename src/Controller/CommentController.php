<?php

namespace App\Controller;
use App\Entity\Blog;
use App\Entity\Comment;
use App\Form\Comment1Type;
use DateTimeImmutable;
use App\Repository\BlogRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/{id}/comment')]
class CommentController extends AbstractController
{

    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Blog $blog, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);
        $comment -> setCreatedAt (new DateTimeImmutable());
        $comment -> setUser($this->getUser());
        $comment -> setBlog($blog);
        $rr = $this->filterwords($comment->getContent());
        $comment->setContent($rr);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    public function filterwords($text)
    {
        $filterWords = array('stupid', 'mauvais', '0', 'false');
        $filterCount = count($filterWords);
        $str = "";
        $data = preg_split('/\s+/',  $text);
        foreach($data as $s){
            $g = false;
            foreach ($filterWords as $lib) {
                if($s == $lib){
                    $t = "";
                    for($i =0; $i<strlen($s); $i++) $t .= "*";
                    $str .= $t . " ";
                    $g = true;
                    break;
                }
            }
            if(!$g)
            $str .= $s . " ";
        }
        return $str;
    }


    // #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    // public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
    //         $commentRepository->remove($comment, true);
    //     }

    //     return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    // }
}
