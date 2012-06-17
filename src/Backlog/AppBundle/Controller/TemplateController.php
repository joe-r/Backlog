<?php

namespace Backlog\AppBundle\Controller;

class TemplateController extends Controller
{
    public function listAction()
    {
        $tpl =  $this->get('bl_app.view.api_templating');

        $response = $this->renderText(json_encode($tpl->getTemplates()));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function showAction($template)
    {
        $tpl =  $this->get('bl_app.view.api_templating');

        $response = $this->renderText(json_encode($tpl->getTemplateSource($template)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
