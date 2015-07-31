<?php

/**
 * Created by PhpStorm.
 * User: skolodyazhny
 * Date: 28/03/14
 * Time: 00:09.
 */
namespace Bcn\Component\StreamWrapper\Tests;

use Bcn\Component\StreamWrapper\Stream;

class ExampleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Reading example.
     */
    public function testExampleReading()
    {
        $stream = new Stream('Content');

        $fh = fopen($stream, 'r');
        $data = fgets($fh);
        fclose($fh);

        $this->assertEquals('Content', $data);
    }

    /**
     * Writing example.
     */
    public function testExampleWriting()
    {
        $stream = new Stream();

        $fh = fopen($stream, 'w');
        fputs($fh, 'Content');
        fclose($fh);

        $this->assertEquals('Content', $stream->getContent());
    }
}
