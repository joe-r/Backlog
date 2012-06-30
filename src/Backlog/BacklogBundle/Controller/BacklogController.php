<?php

namespace Backlog\BacklogBundle\Controller;

use Backlog\AppBundle\Controller\Controller;
use Backlog\BacklogBundle\Entity\Backlog;

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
        $format = $this->getRequest()->attributes->get('_format');
        $this->throwNotFoundUnless($backlog = $this->getRepository('BacklogBacklogBundle:Backlog')->find($uid));

        if ($format == 'html') {
            return $this->render('BacklogBacklogBundle:Backlog:show.html.twig', array(
                'backlog' => $backlog
            ));
        }

        if (!in_array($format, array('xml', 'json'))) {
            throw new \InvalidArgumentException(sprintf('Format "%s" is not supported'));
        }

        return $this->serialize($backlog, $format);
    }

    public function downloadAction($uid)
    {
        $format = $this->getRequest()->query->get('format');

        $response = null;
        $filename = sprintf('backlog_%s.%s', $uid, $format);

        $response = $this->forward('BacklogBacklogBundle:Backlog:show',
            array('uid' => $uid),
            array('_format' => $format)
        );

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Error during download');
        }

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

        return $this->render('BacklogBacklogBundle:Backlog:new.html.twig', array(
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

        return $this->render('BacklogBacklogBundle:Backlog:new.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    public function editAction($uid)
    {
        $backlog = $this->getBacklog($uid);
        $form = $this->createForm('bl_backlog', $backlog);

        return $this->render('BacklogBacklogBundle:Backlog:edit.html.twig', array(
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

        return $this->render('BacklogBacklogBundle:Backlog:edit.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    public function listAction()
    {
        return $this->render('BacklogBacklogBundle:Backlog:list.html.twig', array(
            'backlogs' => $this->getUser()->getBacklogs()
        ));
    }

    protected function getBacklog($uid)
    {
        $this->throwNotFoundUnless(
            $bl = $this->getRepository('BacklogBacklogBundle:Backlog')->find($uid),
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
