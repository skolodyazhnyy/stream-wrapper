<?php

namespace Bcn\Component\StreamWrapper;

use Bcn\Component\StreamWrapper\Stream\Factory;

class Stream
{
    const PROXY_CLASSNAME = 'Proxy';

    /**
     * @var null|string
     */
    protected $id = null;

    /**
     * @var resource
     */
    protected $handle;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var bool
     */
    protected $open;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @param null|string $content
     * @param null|string $filename
     */
    public function __construct($content = null, $filename = null)
    {
        $this->filename = $filename ?: 'stream';
        $this->handle = fopen('php://temp', 'rw+');

        if ($content !== null) {
            $this->write($content);
            $this->seek(0);
        }

        $this->id = Factory::getInstance()->capture($this);
    }

    /**
     *
     */
    public function __destruct()
    {
        Factory::getInstance()->release($this->id);
    }

    /**
     * @param $path
     * @param $mode
     * @param $options
     * @param $opened_path
     *
     * @return bool
     */
    public function open($path, $mode, $options, &$opened_path)
    {
        if ($path != $this->id.'://'.$this->filename || $this->open) {
            return false;
        }

        $this->seek(0, $this->isAppendMode($mode) ? SEEK_END : SEEK_SET);
        $this->open = true;

        return true;
    }

    /**
     * @return bool
     */
    public function close()
    {
        $this->open = false;

        return true;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        return fseek($this->handle, $offset, $whence);
    }

    /**
     * @return int
     */
    public function tell()
    {
        return ftell($this->handle);
    }

    /**
     * @return bool
     */
    public function flush()
    {
        return fflush($this->handle);
    }

    /**
     * @param int $count
     *
     * @return string
     */
    public function read($count)
    {
        return fread($this->handle, $count);
    }

    /**
     * @param $new_size
     *
     * @return bool
     */
    public function truncate($new_size)
    {
        ftruncate($this->handle, $new_size);

        return;
    }

    /**
     * @return bool
     */
    public function eof()
    {
        return feof($this->handle);
    }

    /**
     * @param string $data
     *
     * @return int
     */
    public function write($data)
    {
        return fwrite($this->handle, $data);
    }

    /**
     * @return int
     */
    public function size()
    {
        $stat = $this->stat();

        return $stat['size'];
    }

    /**
     * @return array
     */
    public function stat()
    {
        return fstat($this->handle);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->id.'://'.$this->filename;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUri();
    }

    /**
     * @return null|string
     */
    public function getContent()
    {
        $position = ftell($this->handle);
        fseek($this->handle, 0);
        $content = stream_get_contents($this->handle);
        fseek($this->handle, $position);

        return $content;
    }

    /**
     * @param $mode
     * @return bool
     */
    private function isAppendMode($mode)
    {
        return stripos($mode, 'a') !== false;
    }
}
