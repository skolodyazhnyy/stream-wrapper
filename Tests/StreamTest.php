<?php

/**
 * Created by PhpStorm.
 * User: skolodyazhny
 * Date: 28/03/14
 * Time: 00:09.
 */
namespace Bcn\Component\StreamWrapper\Tests;

use Bcn\Component\StreamWrapper\Stream;

class StreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testOpening()
    {
        $stream = new Stream();
        $fh = fopen($stream->getUri(), 'r');
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
        $fh = fopen($stream->getUri(), 'r');
        $actual = fread($fh, $length);
        fclose($fh);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function provideReadData()
    {
        return array(
            'Empty content' => array('', 1000, ''),
            'Read one char' => array('content', 1, 'c'),
            'Read only available content' => array('content', 100, 'content'),
        );
    }

    /**
     *
     */
    public function testGet()
    {
        $stream = new Stream("line1\nline2\nline3");
        $fh = fopen($stream->getUri(), 'r');
        $actual = fgets($fh);
        fclose($fh);

        $this->assertEquals("line1\n", $actual);
    }

    /**
     *
     */
    public function testWrite()
    {
        $string = 'hello';

        $stream = new Stream();
        $fh = fopen($stream->getUri(), 'r');
        $written = fwrite($fh, $string);
        $written += fwrite($fh, $string);
        $written += fwrite($fh, $string);
        fclose($fh);

        $this->assertEquals($string.$string.$string, $stream->getContent());
        $this->assertEquals($written, 3 * strlen($string));
    }

    /**
     *
     */
    public function testAppend()
    {
        $initial = 'hello';
        $string = ' world';

        $stream = new Stream($initial);
        $fh = fopen($stream->getUri(), 'a');
        $written = fwrite($fh, $string);
        $written += fwrite($fh, $string);
        $written += fwrite($fh, $string);
        fclose($fh);

        $this->assertEquals($initial.$string.$string.$string, $stream->getContent());
        $this->assertEquals($written, 3 * strlen($string));
    }

    /**
     * @param $start
     * @param $offset
     * @param $whence
     * @param $size
     * @param $tell
     *
     * @dataProvider provideSeekAndTell
     */
    public function testSeekAndTell($start, $offset, $whence, $size, $tell)
    {
        $stream = new Stream(str_repeat('X', $size));
        $stream->seek($start,  SEEK_SET);
        $stream->seek($offset, $whence);

        $this->assertEquals($tell, $stream->tell());
    }

    /**
     * @return array
     */
    public function provideSeekAndTell()
    {
        return array(
            'Seeking in empty file' => array(0,  100, SEEK_SET, 0, false),
            'Seek set' => array(10, 5,   SEEK_SET, 20, 5),
            'Seek cur' => array(10, 5,   SEEK_CUR, 20, 15),
            'Seek end' => array(10, -5,  SEEK_END, 20, 15),
            'Seek to the end' => array(10, 0, SEEK_END, 19, 19),
            'Seek over the end' => array(10, 10,  SEEK_CUR, 19, false),
        );
    }

    /**
     *
     */
    public function testCustomUri()
    {
        $filename = 'custom/path/custom.name';
        $stream = new Stream('Content', $filename);
        $uri = (string) $stream;
        list($wrapper, $name) = explode('://', $uri, 2);

        // Name changed
        $this->assertEquals($filename, $name);

        // Can't open stream by default name
        $defaultName = implode('://', array($wrapper, 'stream'));
        $this->assertFalse(@fopen($defaultName, 'r'));

        // Stream opens with custom name
        $this->assertTrue((boolean) fopen($stream, 'r'));
    }

    /**
     *
     */
    public function testStat()
    {
        $stream = new Stream();
        $stat = stat($stream);

        $keys = array(
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,
            'dev', 'ino', 'mode', 'nlink', 'uid','gid', 'rdev', 'size', 'atime', 'mtime', 'ctime', 'blksize', 'blocks',
        );

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $stat);
        }
    }
}
