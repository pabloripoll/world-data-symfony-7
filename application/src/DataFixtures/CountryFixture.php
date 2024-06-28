<?php

namespace App\DataFixtures;

use App\Entity\WorldCountry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

class CountryFixture extends Fixture implements ORMFixtureInterface
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
        $this->loadCountries();
    }

    /**
     * Seeder Collections
     */
    private function loadCountries(): void
    {
        $name = "Argnetina";
        $properties = [
            "bestFootballPlayer" => "Diego Maradona"
        ];

        $em = $this->entityManager;
        $em->beginTransaction();

        try {

            $entity = new WorldCountry;
            $entity->setName($name);
            $entity->setContent($properties);

            $em->persist($entity);
            $em->flush();

            $em->commit();

        } catch(\Exception $e) {
            $em->rollback();
        }
    }

}
