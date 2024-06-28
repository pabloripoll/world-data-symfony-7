<?php

namespace App\Controller\Site\Public;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitePublic extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {

    }

    #[Route('/', name: 'webadmin_world_index')]
    public function index()
    {
        return new RedirectResponse($this->urlGenerator->generate('webadmin_world_dashboard'));
    }

}
