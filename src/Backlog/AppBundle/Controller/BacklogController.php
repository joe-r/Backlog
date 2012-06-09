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
        $backlog = $this->getRepository('BacklogAppBundle:Backlog')->find($uid);
        if (!$backlog) {
            throw $this->createNotFoundException(sprintf("Backlog %s not found", $uid));
        }

        $form = $this->createForm('bl_backlog', $backlog);

        return $this->render('BacklogAppBundle:Backlog:edit.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    public function saveAction($uid)
    {
        $backlog = $this->getRepository('BacklogAppBundle:Backlog')->find($uid);
        if (!$backlog) {
            throw $this->createNotFoundException(sprintf("Backlog %s not found", $uid));
        }

        $form = $this->createForm('bl_backlog', $backlog);
        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
            $this->persistAndFlush($backlog);

            return $this->redirect($this->generateUrl('bl_backlog_show', array('uid' => $uid)));
        }

        return $this->render('BacklogAppBundle:Backlog:edit.html.twig', array(
            'form' => $form->createView(),
            'backlog' => $backlog
        ));
    }

    /**
     * List backlogs
     */
    public function listAction()
    {
        return $this->render('BacklogAppBundle:Backlog:list.html.twig', array(
            'backlogs' => $this->getUser()->getBacklogs()
        ));
    }

    /**
     * Show a backlog
     */
    public function showAction($uid)
    {
        $backlog = $this->getRepository('BacklogAppBundle:Backlog')->find($uid);

        if (!$backlog) {
            throw $this->createNotFoundException();
        }

        return $this->render('BacklogAppBundle:Backlog:show.html.twig', array(
            'backlog' => $backlog
        ));
    }

    protected function createBacklog()
    {
        $backlog = new Backlog();
        $backlog->setOwner($this->getUser());

        return $backlog;
    }
}
