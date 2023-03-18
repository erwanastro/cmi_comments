<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Form\Type\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comments/{id}/create', name: 'comment_create', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function create(Movie $movie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setAuthor($this->getUser());
            $comment->setMovie($movie);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('movie_show', ['id' => $movie->getId()]);
        }

        return $this->render('Comment/create.html.twig', [
            'form' => $form,
            'movie' => $movie,
        ]);
    }

    #[Route('/comments/{id}/answer', name: 'comment_answer', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function answer(Comment $parent, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Comment $comment */
            $comment = $form->getData();
            $comment->setAuthor($this->getUser());
            $comment->setParent($parent);
            $comment->setMovie($parent->getMovie());
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('movie_show', ['id' => $parent->getMovie()->getId()]);
        }

        return $this->render('Comment/create.html.twig', [
            'form' => $form,
            'movie' => $parent->getMovie(),
        ]);
    }

    #[Route('/comments/{id}/like', name: 'comment_like', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function like(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment->setLikes($comment->getLikes() + 1);
        $entityManager->flush();

        return new RedirectResponse($request->headers->get('referer'));
    }
}
