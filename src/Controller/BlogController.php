<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Form\BlogFormType;
use App\Repository\BlogRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Comment1Type;
use DateTimeImmutable;

class BlogController extends AbstractController
{
    #[Route('/afficherBlog', name: 'app_afficherBlog')]
    public function afficherBlog(BlogRepository $repo): Response
    {
        return $this->render('blog/index.html.twig', [
            'blogs' => $repo->findAll(),
        ]);
    }

    #[Route('/ajouterBlog', name: 'app_blog_new')]
    public function ajouterBlog(Request $request,EntityManagerInterface $manager): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogFormType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('blog_form')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('userpic_directory'), $filename);
            $blog->setImage($filename);

            $manager->persist($blog);
            $manager->flush();
            
            return $this->redirectToRoute('app_afficherBlog');
        }

        return $this->renderForm('blog/ajouterBlog.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }
    #[Route('/afficherBlogFront/{id}', name: 'app_frontBlog')]
    public function afficherBlogFront(Request $request, CommentRepository $commentRepository,EntityManagerInterface $manager,$id,BlogRepository $blogRepository,Blog $blog): Response
    {
        $comment = new Comment();
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);
        $comment -> setCreatedAt (new \DateTime("now"));
        $comment -> setUser($this->getUser());
        $comment -> setBlog($blog);
        $rr = $this->filterwords($comment->getContent());
        $comment->setContent($rr);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_frontBlog',array('id' => $id));
        }
           return $this->render('blog/frontBlog.html.twig',[
            'blog' => $blogRepository->find($id),
            'Blogs' => $blogRepository->findAll(),
            'comments' => $commentRepository->findAll(),
            'form'  => $form->createView()
        ] );
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

    #[Route('/edit/{id}', name: 'app_blog_edit')]
    public function edit(Request $request, Blog $blog,EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(BlogFormType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('blog_form')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('userpic_directory'), $filename);
            $blog->setImage($filename);

            $manager->persist($blog);
            $manager->flush();

            return $this->redirectToRoute('app_afficherBlog');
        }

        return $this->renderForm('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('show/{id}', name: 'app_blog_show')]
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }
    
    #[Route('delete/{id}', name: 'app_blog_delete')]
    public function delete(Request $request, Blog $blog, BlogRepository $blogRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $blogRepository->remove($blog, true);
        }

        return $this->redirectToRoute('app_afficherBlog');
    }
}
