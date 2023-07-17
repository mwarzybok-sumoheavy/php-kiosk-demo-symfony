<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\PaymentCurrency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentCurrency>
 *
 * @method PaymentCurrency|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentCurrency|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentCurrency[]    findAll()
 * @method PaymentCurrency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentCurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentCurrency::class);
    }

    public function save(PaymentCurrency $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentCurrency $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
