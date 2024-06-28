<?php

namespace App\Controller\Site\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteAdminDefault extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {

    }

    #[Route('/admin', name: 'webadmin_default')]
    public function index()
    {
        return new RedirectResponse($this->urlGenerator->generate('webadmin_world_dashboard'));
    }
}
