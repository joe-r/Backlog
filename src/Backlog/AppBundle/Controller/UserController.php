<?php

namespace Backlog\AppBundle\Controller;

use Backlog\AppBundle\Entity\User;

class UserController extends Controller
{
    public function registerAction()
    {
        $user = new User();
        $form = $this->createForm('bl_register', $user);

        return $this->render('BacklogAppBundle:User:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function registerPostAction()
    {
        $user = new User();
        $form = $this->createForm('bl_register', $user);
        $form->bindRequest($this->getRequest());

        if ($form->isValid()) {
            $this->doRegister($user);

            return $this->redirect($this->generateUrl('bl_user_registerSuccess'));
        }

        return $this->render('BacklogAppBundle:User:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function registerSuccessAction()
    {
        return $this->render('BacklogAppBundle:User:registerSuccess.html.twig');
    }

    protected function doRegister(User $user)
    {
        $this->persistAndFlush($user);
    }
}
