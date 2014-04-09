<?php

namespace Bcn\Component\StreamWrapper;

use Bcn\Component\StreamWrapper\Stream\Factory;

class Stream
{

    const PROXY_CLASSNAME = "Proxy";

    /** @var null|string */
    protected $id = null;
    /** @var string $content */
    protected $content;
    /** @var int */
    protected $position;
    /** @var boolean */
    protected $open;
    /** @var string */
    protected $filename;

    /**
     * @param null|string $content
     * @param null|string $filename
     */
    public function __construct($content = null, $filename = null)
    {
        $this->content  = $content;
        $this->position = -1;
        $this->filename = $filename ?: "stream";

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
     * @return bool
     */
    public function open($path, $mode, $options, &$opened_path)
    {
        if ($path == $this->id . "://" . $this->filename && !$this->open) {
            $this->open = true;

            return true;
        }

        return false;
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
     * @param $offset
     * @param  int $whence
     * @return int
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        switch ($whence) {
            case SEEK_CUR:
                $this->position += $offset;
                break;
            case SEEK_SET:
                $this->position = $offset;
                break;
            case SEEK_END:
                $this->position = $this->size() + $offset;
                break;
        }

        if ($this->position >= $this->size()) {
            $this->position = $this->size() - 1;
        }

        return $this->position;
    }

    /**
     * @return int
     */
    public function tell()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function flush()
    {
        return true;
    }

    /**
     * @param  int    $count
     * @return string
     */
    public function read($count)
    {
        $start = $this->position + 1;
        $this->seek($count, SEEK_CUR);

        return mb_substr($this->content, $start, $count);
    }

    /**
     * @param $new_size
     * @return bool
     */
    public function truncate($new_size)
    {
        $this->content = mb_substr($this->content, 0, $new_size);
        $this->seek(0, SEEK_CUR);

        return null;
    }

    /**
     * @return boolean
     */
    public function eof()
    {
        return $this->position + 1 >= $this->size();
    }

    /**
     * @param  string $data
     * @return int
     */
    public function write($data)
    {
        $prepend = mb_substr($this->content, 0, $this->position + 1);
        $append  = mb_substr($this->content, $this->position + 1 + mb_strlen($data));

        $this->content = $prepend . $data . $append;
        $this->seek(mb_strlen($data), SEEK_CUR);

        return mb_strlen($data);
    }

    /**
     * @return int
     */
    public function size()
    {
        return mb_strlen($this->content);
    }

    /**
     * @return array
     */
    public function stat()
    {
        $stat = array(
            'dev'       => 19,
            'ino'       => 0,
            'mode'      => 0100666,
            'nlink'     => 1,
            'uid'       => 1,
            'gid'       => 1,
            'rdev'      => 0,
            'size'      => $this->size(),
            'atime'     => time(),
            'mtime'     => time(),
            'ctime'     => time(),
            'blksize'   => -1,
            'blocks'    => -1
        );

        return array_merge(array_values($stat), $stat);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->id . "://" . $this->filename;
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
        return $this->content;
    }

}
