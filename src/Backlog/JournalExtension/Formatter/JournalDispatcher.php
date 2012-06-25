<?php

namespace Backlog\JournalExtension\Formatter;

use Behat\Behat\Formatter\FormatterDispatcher;
use Behat\Mink\Mink;

class JournalDispatcher extends FormatterDispatcher
{
    protected $mink;

    public function __construct(Mink $mink)
    {
        $this->mink = $mink;

        parent::__construct(
            'Backlog\JournalExtension\Formatter\JournalFormatter',
            'journal',
            'HTML with screenshots'
        );
    }

    public function createFormatter()
    {
        return new JournalFormatter($this->mink);
    }
}
