<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\PaymentCurrencyMinerFee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentCurrencyMinerFee>
 *
 * @method PaymentCurrencyMinerFee|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentCurrencyMinerFee|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentCurrencyMinerFee[]    findAll()
 * @method PaymentCurrencyMinerFee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentCurrencyMinerFeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentCurrencyMinerFee::class);
    }

    public function save(PaymentCurrencyMinerFee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentCurrencyMinerFee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
