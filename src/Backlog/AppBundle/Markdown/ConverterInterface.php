<?php

namespace Backlog\AppBundle\Markdown;

interface ConverterInterface
{
    public function convertToHtml($markdown, $encoding = 'UTF-8');
}
