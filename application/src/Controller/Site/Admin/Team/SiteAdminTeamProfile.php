<?php

namespace App\Controller\Site\Admin\Team;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/team')]
class SiteAdminTeamProfile extends AbstractController
{
    public function __construct()
    {

    }

    #[Route('/profiles', name: 'webadmin_team_profiles')]
    public function template(Request $request)
    {

        return $this->render('admin/template.html.twig', [
            'layout' => 'admin/layout/team/profiles.html.twig',
            'user' => 'pablo'
        ]);
    }

}
