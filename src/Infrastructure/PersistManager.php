<?php
declare(strict_types=1);

namespace App\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;

class PersistManager
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persist(object $entity): void
    {
        $this->em->persist($entity);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
