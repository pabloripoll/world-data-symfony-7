<?php

namespace App\Controller\Site\Admin\World;

use App\Entity\WorldCountry;
use App\Repository\WorldCountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WorldCountryCustomPropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/world')]
class SiteAdminWorldDashboard extends AbstractController
{
    #[Route('/dashboard', name: 'webadmin_world_dashboard')]
    public function template(WorldCountryRepository $countryRepo, WorldCountryCustomPropertyRepository $propertyRepo)
    {
        $totalCountries = 195;

        $countriesRegistered = count($countryRepo->getAll() ?? []);
        $totalCountriesRegistered = round($countriesRegistered * 100 / $totalCountries);

        $properties = $propertyRepo->getId(1);
        $totalPropertiesRegistered = count($properties->content ?? []);

        return $this->render('admin/template.html.twig', [
            'totalCountries' => $totalCountries,
            'totalCountriesRegistered' => $totalCountriesRegistered,
            'totalPropertiesRegistered' => $totalPropertiesRegistered,
            'layout' => 'admin/layout/world/dashboard.html.twig'
        ]);
    }

}
