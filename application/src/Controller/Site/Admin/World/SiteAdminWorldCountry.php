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
class SiteAdminWorldCountry extends AbstractController
{
    #[Route('/countries', methods:['GET'], name: 'webadmin_world_countries')]
    public function countries(WorldCountryRepository $repository)
    {
        $countries = $repository->getAll();

        foreach ($countries as $key => $country) {
            $countries[$key]->properties = count($country->content);
        }

        return $this->render('admin/template.html.twig', [
            'countries' => $countries,
            'layout' => 'admin/layout/world/countries.html.twig',
            'js_scripts' => [
                ['/theme/admin/layout/world/countries.js']
            ]
        ]);
    }

    #[Route('/countries/create', methods:['GET'], name: 'webadmin_world_countries_create_layout')]
    public function countriesCreateLayout(WorldCountryCustomPropertyRepository $propertyRepository)
    {
        $properties = $propertyRepository->getAll();

        return $this->render('admin/template.html.twig', [
            'properties' => json_encode($properties),
            'layout' => 'admin/layout/world/countries-create.html.twig',
            'js_scripts' => [
                ['/theme/admin/layout/world/countries-create.js']
            ]
        ]);
    }

    #[Route('/countries/create', methods:['POST'], name: 'webadmin_world_countries_create_register')]
    public function countriesCreateRegister(Request $request, EntityManagerInterface $entityManager): Response
    {
        $request = $request->getPayload();
        $name = $request->get('name');
        $data = json_decode($request->get('data'), true);

        try {
            $entity = new WorldCountry;
            $entity->setName($name);
            $entity->setContent($data);
            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->json(['id' => $entity->getId()]);

        } catch(\Exception $e) {
            return $this->json(['error' => json_encode($e->getMessage())]);
        }

        return $this->json(['id' => $data]);
    }

    #[Route('/countries/profile', methods:['GET'], name: 'webadmin_world_countries_profile_layout')]
    public function countriesProfileLayout(Request $request, WorldCountryRepository $repository)
    {
        $id = $request->query->get('id');
        $country = $repository->getId($id);

        return $this->render('admin/template.html.twig', [
            'country' => $country,
            'properties' => json_encode($country->content),
            'layout' => 'admin/layout/world/countries-profile.html.twig',
            'js_scripts' => [
                ['/theme/admin/layout/world/countries-profile.js']
            ]
        ]);
    }

    #[Route('/countries/update', methods:['GET'], name: 'webadmin_world_countries_update_layout')]
    public function countriesUpdateLayout(Request $request, WorldCountryRepository $repository, WorldCountryCustomPropertyRepository $propertyRepository)
    {
        $id = $request->query->get('id');
        $country = $repository->getId($id);
        $properties = $propertyRepository->getAll();

        return $this->render('admin/template.html.twig', [
            'country' => $country,
            'content' => json_encode($country->content),
            'properties' => json_encode($properties),
            'layout' => 'admin/layout/world/countries-update.html.twig',
            'js_scripts' => [
                ['/theme/admin/layout/world/countries-update.js']
            ]
        ]);
    }

    #[Route('/countries/update', methods:['POST'], name: 'webadmin_world_countries_update_register')]
    public function countriesUpdateRegister(Request $request, EntityManagerInterface $entityManager): Response
    {
        $request = $request->getPayload();

        $id = $request->get('id');
        $name = $request->get('name');
        $data = json_decode($request->get('data'), true);

        try {
            $register = $entityManager->getRepository(WorldCountry::class)->find($id);
            if ($register) {
                $register->setName($name);
                $register->setContent($data);
                $entityManager->flush();
            }

            return $this->json(['id' => $register->getId()]);

        } catch(\Exception $e) {
            return $this->json(['error' => json_encode($e->getMessage())]);
        }
    }

    #[Route('/countries/delete', methods:['POST'], name: 'webadmin_world_countries_delete_register')]
    public function countriesDeleteRegister(Request $request, EntityManagerInterface $entityManager): Response
    {
        $request = $request->getPayload();

        $id = $request->get('id');

        try {
            $register = $entityManager->getRepository(WorldCountry::class)->find($id);
            if ($register) {
                $entityManager->remove($register);
                $entityManager->flush();
            }

            return $this->json(['id' => 'deleted']);

        } catch(\Exception $e) {
            return $this->json(['error' => json_encode($e->getMessage())]);
        }
    }

}
