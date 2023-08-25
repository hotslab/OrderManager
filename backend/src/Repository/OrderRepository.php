<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addOrder(Order $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Order[] Returns an array of Order objects
     */
    public function findAllPaginatedOrders(array $searchValues = [], $page, $pageSize): array
    {
        $qb = $this->createQueryBuilder('o');
        foreach ($searchValues as $key => $value) {
            if ($key == 'customer' && $value) {
                $qb->where('o.customer LIKE :customer')->setParameter('status', '%' . $value . '%');
            }
            if ($key == 'status' && $value) {
                $qb->where('o.status = :status')->setParameter('status', $value);
            }
        }
        $qb->orderBy('o.id', 'ASC');
        $paginator  = new \Doctrine\ORM\Tools\Pagination\Paginator($qb);

        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        $data = $paginator->getQuery()
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize)
            ->getResult();

        return [
          'data' => $data,
          'currentPage' => $page,
          'pages' => $pagesCount,
          'total' => $totalItems
        ];
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function cancelOrder(Order $entity, bool $flush = true): void
    {
        $entity->setStatus('cancelled');
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
