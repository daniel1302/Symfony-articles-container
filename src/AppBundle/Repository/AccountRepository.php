<?php
namespace AppBundle\Repository;

use AppBundle\Entity\AccountQuestion;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class AccountRepository extends EntityRepository {
    public static $alias = 'a';

    public function getTestRank()
    {
        $query = $this->createQueryBuilder(self::$alias)
            ->select([self::$alias.'.id', self::$alias.'.firstname', self::$alias.'.surname', 'SUM(aq.points) as points'])
            ->leftJoin(AccountQuestion::class, 'aq', Join::WITH, 'aq.account='.self::$alias.'.id')
            ->groupBy(self::$alias.'.id')
            ->orderBy('points', 'DESC');

        $results = $query
            ->getQuery()
            ->getResult();


        if (empty($results)) {
            return [];
        }

        return $results;
    }
}