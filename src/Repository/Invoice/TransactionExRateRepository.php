<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\TransactionExRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TransactionExRate>
 *
 * @method TransactionExRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionExRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionExRate[]    findAll()
 * @method TransactionExRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionExRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionExRate::class);
    }

    public function save(TransactionExRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TransactionExRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
