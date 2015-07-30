<?php

/**
 * This file is part of the Stream Wrapper Project.
 *
 * @author Sergey Kolodyazhnyy <skolodyazhnyy@ebay.com>
 */
namespace Bcn\Component\StreamWrapper\Tests;

use Bcn\Component\StreamWrapper\Stream;

class FileFunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testFileExists()
    {
        $this->assertTrue(file_exists(new Stream()));
    }

    /**
     *
     */
    public function testFileReadable()
    {
        $this->assertTrue(is_readable(new Stream()));
    }

    /**
     *
     */
    public function testFileWritable()
    {
        $this->assertTrue(is_writable(new Stream()));
    }

    /**
     *
     */
    public function testIsFile()
    {
        $this->assertTrue(is_file(new Stream()));
    }

    /**
     *
     */
    public function testIsDir()
    {
        $this->assertFalse(is_dir(new Stream()));
    }
}
