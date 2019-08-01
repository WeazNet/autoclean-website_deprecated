<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Leboncoin;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\AdRepository;
use App\Entity\Ad;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\AdSearch;
use App\Form\AdSearchType;
use App\Repository\ViewerRepository;
use App\Entity\Viewer;

class AdController extends AbstractController 
{
    /**
     * @var AdRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(AdRepository $repository, ObjectManager $em, PaginatorInterface $paginator) {
        $this->repository = $repository;
        $this->em = $em;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/nos-annonces", name="ad.index")
     * @param  mixed $paginator
     * @param  mixed $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $search = new AdSearch();
        $form = $this->createForm(AdSearchType::class, $search);
        $form->handleRequest($request);

        $formAv = $this->createForm(AdSearchType::class, $search);
        $formAv->handleRequest($request);

        $ads = $this->paginator->paginate(
            $this->repository->findAllQuery($search),
            $request->query->getInt('page', 1),
            10
        );

        $total = count($this->repository->findAll());
        
        $latest = $this->repository->findAllLatest();

        $brands = (new AdSearch)->countBrands($this->repository);

        return $this->render('ad/index.html.twig', [
            'active' => 'ad',
            'ads' => $ads,
            'brands' => $brands,
            'latest_ads' => $latest,
            'total_ads' => $total,
            'search' => $form->createView(),
            'search_av' => $formAv->createView()
        ]);
    }

    /**
     * @Route("/annonce/{slug}-{id}", name="ad.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param  mixed $ad
     * @param  mixed $slug
     * @return Response
     */
    public function show(Ad $ad, string $slug, ViewerRepository $repository): Response
    {
        // add Viewer //
        $checked = false;
        $current_ip = $_SERVER['REMOTE_ADDR'];

        $viewers = $repository->findAll();
        foreach ($viewers as $viewer) {
            if($current_ip == $viewer->getIp())
            {
                $checked = true;
            }
        }
        
        if(!$checked){
            $viewer = new Viewer();
            $viewer->setIp($current_ip);
        } else {
            $viewer = $repository->findOneBy(['ip' => $current_ip]);
        }
            $ad->addViewerId($viewer);
            $this->em->persist($ad);
            $this->em->flush();

        $adSlug = $ad->getSlug();
        if($adSlug !== $slug) {
            return $this->redirectToRoute('ad.show', [
                'id' => $ad->getId(),
                'slug' => $adSlug
            ], 301);
        }

        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
            'active' => 'ad'
        ]);
    }

    /**
     * @Route("/nos-annonces/load", name="ad.load")
     * @return Response
     */
    public function load(): Response
    {
        $lb = new Leboncoin($this->em);
        $ads = $lb->getAds($this->repository);

        $this->addFlash('updated', $ads[0]);
        $this->addFlash('removed', $ads[1]);

        return $this->redirectToRoute('ad.index');
    }
}