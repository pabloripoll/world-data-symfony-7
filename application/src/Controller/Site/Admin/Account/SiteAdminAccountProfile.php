<?php

namespace App\Controller\Site\Admin\Account;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/account')]
class SiteAdminAccountProfile extends AbstractController
{
    public function __construct()
    {

    }

    #[Route('/profile', name: 'webadmin_account_profile')]
    public function template(Request $request)
    {

        return $this->render('admin/template.html.twig', [
            'layout' => 'admin/layout/account/profile.html.twig',
            'user' => 'pablo'
        ]);
    }

}
