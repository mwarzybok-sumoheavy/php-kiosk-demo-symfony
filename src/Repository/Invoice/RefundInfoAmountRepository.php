<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\RefundInfoAmount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RefundInfoAmount>
 *
 * @method RefundInfoAmount|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefundInfoAmount|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefundInfoAmount[]    findAll()
 * @method RefundInfoAmount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefundInfoAmountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefundInfoAmount::class);
    }

    public function save(RefundInfoAmount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RefundInfoAmount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
