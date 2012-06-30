<?php

namespace Backlog\UserBundle\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\SecurityContext;

use Backlog\AppBundle\Controller\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        $form = $this->get('form.factory')->createNamed('', 'bl_login');

        if ($error = $this->getErrorMessage()) {
            $form->addError(new FormError($error));
        }

        return $this->render('BacklogUserBundle:Session:login.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function loginCheckAction()
    {
        throw new \RuntimeException("Action should not be reached");
    }

    protected function getErrorMessage()
    {
        $request = $this->getRequest();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
            $request->getSession()->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        if ($error instanceof \Exception) {
            $error = $error->getMessage();
        }

        return $error;
    }
}
