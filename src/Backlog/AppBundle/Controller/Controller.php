<?php

namespace Backlog\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Entity\Repository;

abstract class Controller extends BaseController
{
    /**
     * Returns a Doctrine repository
     *
     * @return Repository
     */
    protected function getRepository($name)
    {
        return $this->getDoctrine()->getRepository($name);
    }

    protected function persistAndFlush($entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
    }

    /**
     * Renders a basic text response
     *
     * @return Response
     */
    protected function renderText($text)
    {
        return new Response($text);
    }
}
