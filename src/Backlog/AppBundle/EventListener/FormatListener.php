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

        if ($format = $request->query->get('_format')) {
            if (!in_array($format, array('html', 'json'))) {
                throw new \RuntimeException('Unexpected _format value');
            }
        } else {
            foreach ($request->getAcceptableContentTypes() as $type) {
                if ('text/html' == $type) {
                    $format = 'html';
                    break;
                }
                if ('application/json' == $type) {
                    $format = 'json';
                    break;
                }
                if ('text/xml' == $type) {
                    $format = 'xml';
                }
            }
        }

        $request->attributes->set('_format', $format !== null ? $format : self::DEFAULT_FORMAT);
    }
}
