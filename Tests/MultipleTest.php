<?php

/**
 * Created by PhpStorm.
 * User: skolodyazhny
 * Date: 28/03/14
 * Time: 00:09.
 */
namespace Bcn\Component\StreamWrapper\Tests;

use Bcn\Component\StreamWrapper\Stream;

class MultipleTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testMultipleStreamsInParallel()
    {
        /** @var Stream[] $streams */
        $streams = array();
        $fhs = array();
        $tests = 100;

        for ($i = 0; $i < $tests; ++$i) {
            $streams[$i] = new Stream();
            $fhs[$i] = fopen($streams[$i], 'w');
        }

        for ($i = 0; $i < $tests; ++$i) {
            fputs($fhs[$i], 'Stream#'.$i);
        }

        for ($i = 0; $i < $tests; ++$i) {
            fclose($fhs[$i]);
            $this->assertEquals('Stream#'.$i, $streams[$i]->getContent());
        }
    }
}
