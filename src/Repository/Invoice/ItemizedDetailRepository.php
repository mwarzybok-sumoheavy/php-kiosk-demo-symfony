<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\ItemizedDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemizedDetail>
 *
 * @method ItemizedDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemizedDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemizedDetail[]    findAll()
 * @method ItemizedDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemizedDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemizedDetail::class);
    }

    public function save(ItemizedDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ItemizedDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
