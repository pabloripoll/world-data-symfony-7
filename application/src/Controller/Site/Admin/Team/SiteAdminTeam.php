<?php

namespace App\Controller\Site\Admin\Team;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteAdminTeam extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {

    }

    #[Route('/admin/team', name: 'webadmin_team_index')]
    public function index()
    {
        return new RedirectResponse($this->urlGenerator->generate('webadmin_team_profiles'));
    }

}
