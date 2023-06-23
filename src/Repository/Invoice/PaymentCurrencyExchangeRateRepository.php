<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\PaymentCurrencyExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentCurrencyExchangeRate>
 *
 * @method PaymentCurrencyExchangeRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentCurrencyExchangeRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentCurrencyExchangeRate[] findAll()
 * @method PaymentCurrencyExchangeRate[] findBy(array $criteria, array $orderBy = null, $limit = null,$offset = null)
 */
class PaymentCurrencyExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentCurrencyExchangeRate::class);
    }

    public function save(PaymentCurrencyExchangeRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentCurrencyExchangeRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
