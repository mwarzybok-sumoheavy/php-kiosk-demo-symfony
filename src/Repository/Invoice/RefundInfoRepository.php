<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\RefundInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RefundInfo>
 *
 * @method RefundInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefundInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefundInfo[]    findAll()
 * @method RefundInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefundInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefundInfo::class);
    }

    public function save(RefundInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RefundInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
