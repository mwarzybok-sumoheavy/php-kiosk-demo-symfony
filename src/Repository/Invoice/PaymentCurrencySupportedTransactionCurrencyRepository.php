<?php

namespace App\Repository\Invoice;

use App\Entity\Invoice\PaymentCurrencySupportedTransactionCurrency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentCurrencySupportedTransactionCurrency>
 *
 * @method PaymentCurrencySupportedTransactionCurrency|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentCurrencySupportedTransactionCurrency|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentCurrencySupportedTransactionCurrency[] findAll()
   // phpcs:ignore
 * @method PaymentCurrencySupportedTransactionCurrency[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentCurrencySupportedTransactionCurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentCurrencySupportedTransactionCurrency::class);
    }

    public function save(PaymentCurrencySupportedTransactionCurrency $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentCurrencySupportedTransactionCurrency $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
