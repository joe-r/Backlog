<?php

namespace Backlog\MarkdownBundle\Markdown;

interface ConverterInterface
{
    public function convertToHtml($markdown, $encoding = 'UTF-8');
}
