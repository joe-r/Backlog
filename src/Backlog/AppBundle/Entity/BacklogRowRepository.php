<?php

namespace Backlog\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BacklogRowRepository extends EntityRepository
{
    public function moveToPosition(BacklogRow $row, $to)
    {
        $from = $row->getPosition();
        $dqlParams = array(
            'backlog_uid' => $row->getBacklog()->getUid(),
            'from'        => $from,
            'to'          => $to
        );

        if ($from > $to) {
            $dql ='
                UPDATE Backlog\AppBundle\Entity\BacklogRow br
                SET br.position = br.position + 1
                WHERE br.backlog = :backlog_uid AND br.position >= :to AND br.position < :from
            ';
        } elseif ($from < $to) {
            $dql = '
                UPDATE Backlog\AppBundle\Entity\BacklogRow br
                SET br.position = br.position - 1
                WHERE br.backlog = :backlog_uid AND br.position > :from AND br.position <= :to
            ';
        }

        $em = $this->getEntityManager();
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameters($dqlParams);
        $row->setPosition($to);

        $em->transactional(function ($em) use ($row, $q) {
            $q->execute();
            $em->persist($row);
        });

        $em->clear();
    }
}
