<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\WorldCountryCustomProperty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

class CountryPropertyFixture extends Fixture implements ORMFixtureInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Interface method that calls the seed method
     */
    public function load(ObjectManager $manager): void
    {
        $this->seed();
    }

    /**
     * Interface method which run the seeder collections
     */
    public function seed(): void
    {
        $this->loadProperties();
    }

    /**
     * Seeder Collections
     */

    private function loadProperties(): void
    {
        $properties = [
            "bestFood" => "Pizza",
            "mainDance" => "Tango",
            "bestFootballPlayer" => "Diego Maradona"
        ];

        $em = $this->entityManager;
        $em->beginTransaction();

        try {

            $entity = new WorldCountryCustomProperty;
            $entity->setContent($properties);

            $em->persist($entity);
            $em->flush();

            $em->commit();

        } catch(\Exception $e) {
            $em->rollback();
        }
    }

}
