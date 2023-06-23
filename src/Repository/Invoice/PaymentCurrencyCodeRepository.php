<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\PaymentCurrencyCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentCurrencyCode>
 *
 * @method PaymentCurrencyCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentCurrencyCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentCurrencyCode[]    findAll()
 * @method PaymentCurrencyCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentCurrencyCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentCurrencyCode::class);
    }

    public function save(PaymentCurrencyCode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentCurrencyCode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
