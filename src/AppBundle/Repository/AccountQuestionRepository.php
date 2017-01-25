<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Account;
use AppBundle\Entity\Question;
use AppBundle\Entity\Test;
use AppBundle\Model\EntityParser;

class AccountQuestionRepository extends \Doctrine\ORM\EntityRepository
{
    public static $alias = 'aq';

    public function isAnswered(Question $question, Account $account)
    {
        $query = $this->createQueryBuilder(self::$alias)
            ->where(self::$alias . '.question=:question')
            ->andWhere(self::$alias . '.account=:account')
            ->setParameter('question', $question)
            ->setParameter('account', $account);

        $results = $query->getQuery()
            ->getResult();

        if (empty($results)) {
            return false;
        }

        return true;
    }

    public function getAnsweredForTest(Test $test, Account $account = null)
    {
        if ($account === null) {
            return [];
        }
        $query = $this->createQueryBuilder(self::$alias)
            ->join(self::$alias . '.question', 'q')
            ->join('q.test', 't')
            ->where('t=:test')
            ->andWhere(self::$alias . '.account=:account')
            ->setParameter('test', $test)
            ->setParameter('account', $account);

        $results = $query->getQuery()->getResult();
        if (empty($results)) {
            return [];
        }

        return $results;
    }


}
