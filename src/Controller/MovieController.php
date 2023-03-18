<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\CommentRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/', name: 'movie_index')]
    public function index(MovieRepository $movieRepository, CommentRepository $commentRepository): Response
    {
        return $this->render('Movie/index.html.twig', [
            'movies' => $movieRepository->findAll(),
            'latestComments' => $commentRepository->findBy(['parent' => null], ['createdAt' =>  'desc'], 6),
        ]);
    }

    #[Route('/movie/{id}', name: 'movie_show', requirements: ['page' => '\d+'])]
    public function show(Movie $movie): Response
    {
        return $this->render('Movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
