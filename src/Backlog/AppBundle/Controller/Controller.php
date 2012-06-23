<?php

namespace Backlog\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Entity\Repository;

abstract class Controller extends BaseController
{
    protected function getRepository($name)
    {
        return $this->getDoctrine()->getRepository($name);
    }

    protected function throwNotFoundUnless($condition, $message = 'Not found')
    {
        if (!$condition)
        {
            throw $this->createNotFoundException($message);
        }
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
