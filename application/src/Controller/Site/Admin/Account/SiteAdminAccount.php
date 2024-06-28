<?php

namespace App\Controller\Site\Admin\Account;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteAdminAccount extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {

    }

    #[Route('/admin/account', name: 'webadmin_account_index')]
    public function index()
    {
        return new RedirectResponse($this->urlGenerator->generate('webadmin_account_profile'));
    }

}
