<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Leboncoin;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;

class ArticleController extends AbstractController 
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ObjectManager $em, ArticleRepository $repository) 
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/nos-articles", name="article.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(
            $this->repository->findAllQuery(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('article/index.html.twig', [
            'active' => 'article',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{slug}-{id}", name="article.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Article $article, string $slug): Response 
    {
        if($article->getSlug() !== $slug) {
            return $this->redirectToRoute('article.show', [
                'slug' => $article->getSlug(),
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/show.html.twig', [
            'active' => 'article',
            'article' => $article
        ]);
    }

    /**
     * @Route("/nos-articles/load", name="article.load")
     * @return Response
     */
    public function load(): Response
    {
        $lb = new Leboncoin($this->em);
        $articles = $lb->getArticles($this->repository);

        $this->addFlash('updated', $articles[0]);
        $this->addFlash('removed', $articles[1]);

        return $this->redirectToRoute('article.index');
    }

}