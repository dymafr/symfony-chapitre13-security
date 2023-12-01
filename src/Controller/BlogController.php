<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/blog/edit/{id}', name: 'edit_blog')]
    #[IsGranted('ROLE_USER')]
    public function edit(Blog $blog): Response
    {
        $this->denyAccessUnlessGranted('BLOG_EDIT', $blog);

        $user = $this->getUser();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/test', name: 'test')]
    public function test(EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        $user = $userRepo->find(1);
        $blog = new Blog();
        $blog->setContent('123');
        $blog->setAuthor($user);
        $em->persist($blog);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
