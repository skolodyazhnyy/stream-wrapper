<?php
/**
 * Created by PhpStorm.
 * User: skolodyazhny
 * Date: 28/03/14
 * Time: 00:09
 */

namespace Bcn\Component\StreamWrapper\Tests;


use Bcn\Component\StreamWrapper\Stream;

class StreamTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     */
    public function testOpening()
    {
        $stream = new Stream();
        $fh = fopen($stream->uri(), "r");
        fclose($fh);
    }

    /**
     * @param $data
     * @param $length
     * @param $expected
     *
     * @dataProvider provideReadData
     */
    public function testReading($data, $length, $expected)
    {
        $stream = new Stream($data);
        $fh = fopen($stream->uri(), "r");
        $actual = fread($fh, $length);
        fclose($fh);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function provideReadData() {
        return array(
            'Empty content'               => array('', 1000, ''),
            'Read one char'               => array('content', 1, 'c'),
            'Read only available content' => array('content', 100, 'content'),
        );
    }

    /**
     *
     */
    public function testGet()
    {
        $stream = new Stream("line1\nline2\nline3");
        $fh = fopen($stream->uri(), "r");
        $actual = fgets($fh);
        fclose($fh);

        $this->assertEquals("line1\n", $actual);
    }

    /**
     *
     */
    public function testWrite()
    {
        $string = "hello";

        $stream = new Stream();
        $fh = fopen($stream->uri(), "r");
        $written = fwrite($fh, $string);
        fclose($fh);

        $this->assertEquals($string, $stream->content());
        $this->assertEquals($written, strlen($string));
    }

    /**
     *
     */
    public function testExampleReading() {
        $stream = new Stream("Content");

        $fh = fopen($stream, "r");
        $data = fgets($fh);
        fclose($fh);

        $this->assertEquals("Content", $data);
    }

    /**
     *
     */
    public function testExampleWriting() {
        $stream = new Stream();

        $fh = fopen($stream, "r");
        fputs($fh, "Content");
        fclose($fh);

        $this->assertEquals("Content", $stream->content());
    }

}
 