<?php

namespace Backlog\BacklogBundle\Controller;

use Backlog\AppBundle\Controller\Controller;

class BacklogRowController extends Controller
{
    public function moveAction($backlog_uid, $id)
    {
        $repository = $this->getRepository('BacklogBacklogBundle:BacklogRow');

        $row = $repository->findOneBy(array(
            'backlog'     => $backlog_uid,
            'id'          => $id
        ));

        if (!$row) {
            throw $this->createNotFoundException(sprintf('Backlog row not found (%s)', $id));
        }

        $position = $this->getRequest()->request->get('position');

        $repository->moveToPosition($row, $position);

        return $this->renderText('');
    }

    public function showAction($backlog_uid, $id)
    {
        $row = $this->getRepository('BacklogBacklogBundle:BacklogRow')->findOneBy(array(
            'backlog'     => $backlog_uid,
            'id'          => $id
        ));

        if (!$row) {
            throw $this->createNotFoundException(sprintf('Backlog row not found (%s)', $id));
        }

        return $this->render('BacklogBacklogBundle:BacklogRow:show.html.twig', array(
            'row' => $row,
            'backlog' => $row->getBacklog()
        ));
    }

    public function showCommentsAction($backlog_uid, $id)
    {
        $row = $this->getRow($backlog_uid, $id);

        return $this->render('BacklogBacklogBundle:BacklogRow:showComments.html.twig', array(
            'row'     => $row,
            'backlog' => $row->getBacklog()
        ));
    }

    public function newAction($backlog_uid)
    {
        $backlog = $this->getRepository('BacklogBacklogBundle:Backlog')->find($backlog_uid);

        if (!$backlog) {
            throw $this->createNotFoundException(sprintf('Backlog not found (%s)', $backlog_uid));
        }

        $type = $this->getRequest()->query->get('type');
        $provider = $this->get('bl_backlog.row_manager')->getProviderByName($type);
        $row = $provider->getNew();
        $row->setBacklog($backlog);
        $form = $provider->getForm($row);

        return $this->render('BacklogBacklogBundle:BacklogRow:new.html.twig', array(
            'form' => $form->createView(),
            'row' => $row,
            'backlog' => $row->getBacklog(),
            'type' => $type
        ));
    }

    public function editAction($backlog_uid, $id)
    {
        $row = $this->getRow($backlog_uid, $id);

        $provider = $this->get('bl_backlog.row_manager')->getProvider($row);
        $form = $provider->getForm($row);

        return $this->render('BacklogBacklogBundle:BacklogRow:edit.html.twig', array(
            'form' => $form->createView(),
            'row' => $row,
            'backlog' => $row->getBacklog()
        ));
    }

    public function saveAction($backlog_uid, $id)
    {
        $row = $this->getRow($backlog_uid, $id);
        $provider = $this->get('bl_backlog.row_manager')->getProvider($row);
        $form = $provider->getForm($row);

        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
            $this->persistAndFlush($row);

            return $this->redirect($this->generateUrl('bl_backlogrow_show', array(
                'backlog_uid' => $backlog_uid,
                'id'          => $id
            )));
        }

        return $this->render('BacklogBacklogBundle:BacklogRow:edit.html.twig', array(
            'form' => $form->createView(),
            'row' => $row
        ));
    }

    public function saveNewAction($backlog_uid)
    {
        $backlog = $this->getRepository('BacklogBacklogBundle:Backlog')->find($backlog_uid);

        if (!$backlog) {
            throw $this->createNotFoundException(sprintf('Backlog not found (%s)', $backlog_uid));
        }

        $type = $this->getRequest()->query->get('type');
        $provider = $this->get('bl_backlog.row_manager')->getProviderByName($type);
        $row = $provider->getNew();
        $row->setBacklog($backlog);
        $form = $provider->getForm($row);
        $form->bindRequest($this->getRequest());

        if ($form->isValid()) {
            $this->persistAndFlush($row);

            return $this->redirect($this->generateUrl('bl_backlogrow_show', array(
                'backlog_uid' => $backlog_uid,
                'id'          => $row->getId()
            )));
        }

        return $this->render('BacklogBacklogBundle:BacklogRow:new.html.twig', array(
            'form' => $form->createView(),
            'row' => $row,
            'backlog' => $row->getBacklog(),
            'type' => $type
        ));
    }

    protected function getRow($backlog_uid, $id)
    {
        $row = $this->getRepository('BacklogBacklogBundle:BacklogRow')->findOneBy(array(
            'backlog' => $backlog_uid,
            'id' => $id
        ));

        if (!$row) {
            throw $this->createNotFoundException('Unable to find BacklogRow #'.$backlog_uid.'/'.$id);
        }

        return $row;
    }
}
