<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home.index")
     */
    public function index(ArticleRepository $repository) {
        $articles = $repository->findAllLatest();
        return $this->render('home/index.html.twig', [
            'active' => 'home',
            'articles' => $articles
        ]);
    }
}
