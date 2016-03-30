<?php

namespace BigButtonBundle\Repository;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends \Doctrine\ORM\EntityRepository
{
  public function greatestPriority(){

    $qb = $this->createQueryBuilder('t');

    $qb
      ->select('t.name')
      ->orderBy('t.priority','DESC')
      ->setMaxResults(3);

    return $qb
        ->getQuery()
        ->getResult();
  }
}
