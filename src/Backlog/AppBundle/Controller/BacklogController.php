<?php

namespace Backlog\AppBundle\Controller;

use Backlog\AppBundle\Entity\Backlog;

/**
 * Controller for backlog actions.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class BacklogController extends Controller
{
    /**
     * Show a backlog
     */
    public function showAction($uid)
    {
        $this->throwNotFoundUnless($backlog = $this->getRepository('BacklogAppBundle:Backlog')->find($uid));

        $format = $this->getRequest()->attributes->get('_format');

        if ($format == 'html') {
            return $this->render('BacklogAppBundle:Backlog:show.html.twig', array(
            'backlog' => $backlog
            ));
        } elseif ($format == 'json') {
            $response = $this->renderText(json_encode($backlog->toJSON()));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        throw $this->createNotFoundException(sprintf('Unknown format: %s', $format));
    }

    public function downloadAction($uid)
    {
        $format = $this->getRequest()->query->get('format');

        $response = null;
        switch ($format) {
            case 'json':
                $filename = sprintf('backlog_%s.json', $uid);
                $response = $this->forward('BacklogAppBundle:Backlog:show', array(
                    'uid' => $uid,
                ), array(
                    '_format' => $format,
                ));

                if ($response->getStatusCode() !== 200) {
                    throw new \RuntimeException('Unable to fetch JSON data');
                }

                break;
        }

        $this->throwNotFoundUnless($response, sprintf('Format "%s" not supported', $format));

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Content-Disposition', sprintf('Attachment;filename="%s"', $filename));

        return $response;
    }

    /**
     * Displays form for backlog creation
     */
    public function newAction()
    {
        $backlog = $this->createBacklog();
        $form = $this->createForm('bl_backlog', $backlog);

        return $this->render('BacklogAppBundle:Backlog:new.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    public function saveNewAction()
    {
        $backlog = $this->createBacklog();
        $form = $this->createForm('bl_backlog', $backlog);

        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
            $this->persistAndFlush($backlog);

            return $this->redirect($this->generateUrl('bl_backlog_show', array('uid' => $backlog->getUid())));
        }

        return $this->render('BacklogAppBundle:Backlog:new.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    public function editAction($uid)
    {
        $backlog = $this->getBacklog($uid);
        $form = $this->createForm('bl_backlog', $backlog);

        return $this->render('BacklogAppBundle:Backlog:edit.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    public function saveAction($uid)
    {
        $backlog = $this->getBacklog($uid);
        $form = $this->createForm('bl_backlog', $backlog);

        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
            $this->persistAndFlush($backlog);

            return $this->redirect(
                $this->generateUrl('bl_backlog_show', array('uid' => $uid))
            );
        }

        return $this->render('BacklogAppBundle:Backlog:edit.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    public function listAction()
    {
        return $this->render('BacklogAppBundle:Backlog:list.html.twig', array(
            'backlogs' => $this->getUser()->getBacklogs()
        ));
    }

    protected function getBacklog($uid)
    {
        $this->throwNotFoundUnless(
            $bl = $this->getRepository('BacklogAppBundle:Backlog')->find($uid),
            'Unable to find backlog #'.$uid
        );

        return $bl;
    }

    protected function createBacklog()
    {
        $backlog = new Backlog();
        $backlog->setOwner($this->getUser());

        return $backlog;
    }
}
