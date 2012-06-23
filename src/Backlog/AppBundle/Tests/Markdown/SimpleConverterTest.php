<?php

namespace Backlog\AppBundle\Tests\Markdown;

use Backlog\AppBundle\Markdown\SimpleConverter;

class SimpleConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideConversion
     */
    public function testConversion($from, $to)
    {
        $converter = new SimpleConverter();
        $this->assertEquals($to, $converter->convertToHtml($from), $from.' is correctly converted');
    }

    public function provideConversion()
    {
        return array(
            array('<strong>',    '&lt;strong&gt;'),
            array('foo **bar**', 'foo <strong>bar</strong>'),
            array('foo ++bar++', 'foo <em>bar</em>'),
            array('++foo++ ++bar++', '<em>foo</em> <em>bar</em>'),
        );
    }
}
