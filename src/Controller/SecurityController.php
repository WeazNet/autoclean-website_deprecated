<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\AdRepository;
use App\Repository\ViewerRepository;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $lastUsername = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin(AdRepository $repository, ViewerRepository $viewRepository)
    {
        $ads = $repository->findAll();
        $views = $viewRepository->findAll();

        return $this->render('security/admin.html.twig', [
            'ads' => $ads,
            'views' => $views
        ]);
    }
}