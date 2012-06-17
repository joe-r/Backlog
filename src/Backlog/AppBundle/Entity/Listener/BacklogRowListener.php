<?php

namespace Backlog\AppBundle\Entity\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\NoResultException;

use Backlog\AppBundle\Entity\BacklogRow;

class BacklogRowListener
{
    protected $cache_id = array();

    public function prePersist(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        if ($entity instanceof BacklogRow) {
            $this->checkId($em, $entity);
            $this->checkPosition($em, $entity);
        }
    }

    private function checkPosition($em, $row)
    {
        if (null !== $row->getPosition()) {
            return;
        }

        $uid = $row->getBacklog()->getUid();

        if (!isset($this->cachePosition[$uid])) {
            $query = $em->createQuery('
                SELECT MAX(r.position)
                FROM BacklogAppBundle:BacklogRow r
                WHERE r.backlog = :backlog
                GROUP BY r.backlog
            ');
            $query->setParameters(array(
                'backlog' => $row->getBacklog()
            ));

            try {
                $this->cachePosition[$uid] = $query->getSingleScalarResult();
            } catch (NoResultException $e) {
                $this->cachePosition[$uid] = 0;
            }
        }
        $this->cachePosition[$uid]++;
        $row->setPosition($this->cachePosition[$uid]);
    }

    private function checkId($em, $row)
    {
        if (null !== $row->getId()) {
            return;
        }

        $uid = $row->getBacklog()->getUid();

        if (!isset($this->cache_id[$uid])) {
            $query = $em->createQuery('
                SELECT MAX(r.id)
                FROM BacklogAppBundle:BacklogRow r
                WHERE r.backlog = :backlog
                GROUP BY r.backlog
            ');
            $query->setParameters(array(
                'backlog' => $row->getBacklog()
            ));

            try {
                $this->cache_id[$uid] = $query->getSingleScalarResult();
            } catch (NoResultException $e) {
                $this->cache_id[$uid] = 0;
            }
        }
        $this->cache_id[$uid]++;
        $row->setId($this->cache_id[$uid]);
    }
}
