<?php

namespace App\Repository;

use App\Entity\WorldCountry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorldCountry>
 */
class WorldCountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorldCountry::class);
    }

    /**
     * DTO
     */
    protected function object(object | array $row = null): object
    {
        $object = new \stdClass;

        $object->id = $row->getId();
        $object->name = $row->getName();
        $object->content = $row->getContent();
        $object->created_at = $row->getCreatedAt();
        $object->updated_at = $row->getUpdatedAt();

        return $object;
    }

    protected function row(object | array $result): object | array
    {
        return $this->object($result[0]);
    }

    protected function output(object | array $result): object | array
    {
        if ((is_array($result) || is_object($result))) {
            $list = [];
            foreach ($result as $row) {
                $list[] = $this->object($row);
            }
            return $list;
        }

        return is_array($result) ? (object) $this->object($result[0]) : $this->object($result);
    }

    /**
     * Queries
     */

    public function getId(int $id): array | object
    {
        $qb = $this->createQueryBuilder('p')
        ->where('p.id = :id')
        ->setParameter('id', $id);

        $query = $qb->getQuery();
        $result = $query->execute();

        return isset($result[0]) ? $this->row($result) : [];
    }

    public function getAll(): array | object
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->getQuery();
        $result = $query->execute();

        return isset($result[0]) ? $this->output($result) : [];
    }

}
