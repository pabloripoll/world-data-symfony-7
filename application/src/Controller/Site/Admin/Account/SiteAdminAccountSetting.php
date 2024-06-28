<?php

namespace App\Controller\Site\Admin\Account;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/account')]
class SiteAdminAccountSetting extends AbstractController
{
    public function __construct()
    {

    }

    #[Route('/settings', name: 'webadmin_account_settings')]
    public function template(Request $request)
    {

        return $this->render('admin/template.html.twig', [
            'layout' => 'admin/layout/account/settings.html.twig',
            'user' => 'pablo'
        ]);
    }

}
