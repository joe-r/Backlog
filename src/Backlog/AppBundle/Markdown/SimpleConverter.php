<?php

namespace Backlog\AppBundle\Markdown;

class SimpleConverter implements ConverterInterface
{
    public function convertToHtml($markdown, $encoding = 'UTF-8')
    {
        $html = htmlspecialchars($markdown, ENT_QUOTES, $encoding);

        // Simple font styles
        $styles = array(
            '**' => array('<strong>', '</strong>'),
            '++' => array('<em>', '</em>')
        );

        foreach ($styles as $name => $tags) {
            $esc = preg_quote($name);
            $html = preg_replace_callback(sprintf('/%s(.*)%s/', $esc, $esc), function ($args) use ($tags) {
                    return $tags[0].$args[1].$tags[1];
                }, $html)
            ;
        }

        return $html;
    }
}
