<?php

namespace App\Controller\Site\Admin\World;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\WorldCountryCustomProperty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WorldCountryCustomPropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/world')]
class SiteAdminWorldProperty extends AbstractController
{
    #[Route('/properties', methods:['GET'], name: 'webadmin_world_properties_layout')]
    public function propertiesLayout(WorldCountryCustomPropertyRepository $repository)
    {
        $properties = $repository->getAll();

        return $this->render('admin/template.html.twig', [
            'properties' => json_encode($properties),
            'layout' => 'admin/layout/world/properties.html.twig',
            'js_scripts' => [
                ['/theme/admin/layout/world/properties.js']
            ]
        ]);
    }

    #[Route('/properties/persist', methods:['POST'], name: 'webadmin_world_properties_persist')]
    public function propertiesCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $request = $request->getPayload();
        $properties = json_decode($request->get('properties'), true);

        try {
            $output = '';
            $register = $entityManager->getRepository(WorldCountryCustomProperty::class)->find(1);
            if ($register) {
                $register->setContent($properties);
                $entityManager->flush();
                $output = 'updated';
            } else {
                $entity = new WorldCountryCustomProperty;
                $entity->setContent($properties);
                $entityManager->persist($entity);
                $entityManager->flush();
                $output = 'created';
            }

            return $this->json(['status' => $output]);

        } catch(\Exception $e) {
            return $this->json(['error' => json_encode($e->getMessage())]);
        }
    }

}
