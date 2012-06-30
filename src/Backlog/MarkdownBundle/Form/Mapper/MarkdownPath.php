<?php

namespace Backlog\MarkdownBundle\Form\Mapper;

use Symfony\Component\Form\Util\PropertyPath;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

use Backlog\MarkdownBundle\Markdown\ConverterInterface;

class MarkdownPath extends PropertyPath
{
    protected $name;
    protected $converter;

    public function __construct($name, ConverterInterface $converter)
    {
        $this->name = $name;
        $this->converter = $converter;
    }

    public function getValue($objectOrArray)
    {
        return $objectOrArray->{'get'.ucfirst($this->name)}();
    }

    public function setValue(&$objectOrArray, $value)
    {
        $objectOrArray->{'set'.ucfirst($this->name)}($value, $this->converter);
    }
}
