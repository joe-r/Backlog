<?php

namespace Backlog\AppBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class FormatListener
{
    const DEFAULT_FORMAT = 'html';

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        $format = null;
        foreach ($request->getAcceptableContentTypes() as $type) {
            if ('text/html' == $type) {
                $format = 'html';
                break;
            }
        }

        $request->attributes->set('_format', $format !== null ? $format : self::DEFAULT_FORMAT);
    }
}
