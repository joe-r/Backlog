<?php

namespace Backlog\AppBundle\Markdown;

class SimpleConverter implements ConverterInterface
{
    public function convertToHtml($markdown, $encoding = 'UTF-8')
    {
        $html = htmlspecialchars($markdown, ENT_QUOTES, $encoding);

        return str_replace("\n", "<br />", $html);
    }
}
