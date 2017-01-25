<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Account;
use AppBundle\Entity\Test;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends \Doctrine\ORM\EntityRepository
{
    public static $alias = 'q';
    
    public function getSortedForTest(Test $test) {
        $query = $this->createQueryBuilder(self::$alias)
                ->orderBy(self::$alias.'.orderNo')
                ->where(self::$alias.'.test=:test')
                ->setParameter('test', $test);
        
        $results = $query->getQuery()
                ->getResult();
        
        return $results;
    }
    
    public function getQuestionForTest(Test $test, $number) {
        $query = $this->createQueryBuilder(self::$alias)
                ->orderBy(self::$alias.'.orderNo')
                ->where(self::$alias.'.test=:test')
                ->setParameter('test', $test)
                ->setFirstResult($number-1)
                ->setMaxResults(1);
        
        $result = $query->getQuery()
                ->getOneOrNullResult();
        
        return $result;
    }


}
