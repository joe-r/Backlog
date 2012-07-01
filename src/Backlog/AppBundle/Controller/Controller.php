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
        $entity = is_array($entity) ? $entity : array($entity);
        $em = $this->getDoctrine()->getEntityManager();
        foreach ($entity as $e) {
            $em->persist($e);
        }
        $em->flush();
    }

    protected function renderText($text)
    {
        return new Response($text);
    }

    protected function serialize($data, $format, $groups = array())
    {
        switch ($format) {
            case 'xml':
                $type = 'text/xml';
                break;
            case 'json':
                $type = 'application/json';
                break;
            default:
                throw new \InvalidArgumentException('Unknown format: '.$format);
        }

        $serializer = $this->get('serializer');
        $serializer->setGroups($groups);
        $content = $serializer->serialize($data, $format);

        $response = $this->renderText($content);
        $response->headers->set('Content-Type', $type);

        return $response;
    }
}
