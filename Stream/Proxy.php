<?php

namespace Bcn\Component\StreamWrapper\Stream;

use Bcn\Component\StreamWrapper\Stream;

abstract class Proxy implements WrapperInterface
{
    /**
     * @var Stream
     */
    protected $stream;

    /**
     * @var string
     */
    protected $id;

    /**
     * @return Stream
     */
    protected function getStream()
    {
        if (!$this->id) {
            $this->id = str_replace(__CLASS__.'_', '', get_class($this));
        }

        return Factory::getInstance()->getStream($this->id);
    }

    /**
     * @throws \Exception
     */
    public function stream_stat()
    {
        return $this->getStream()->stat();
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    public function stream_seek($offset, $whence = SEEK_SET)
    {
        return $this->getStream()->seek($offset, $whence);
    }

    /**
     * @return mixed|void
     *
     * @throws \Exception
     */
    public function dir_rewinddir()
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @throws \Exception
     */
    public function dir_readdir()
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @return int
     */
    public function stream_tell()
    {
        return $this->getStream()->tell();
    }

    /**
     * @param string $path
     * @param int    $option
     * @param mixed  $value
     *
     * @throws \Exception
     */
    public function stream_metadata($path, $option, $value)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @return bool
     */
    public function stream_close()
    {
        return $this->getStream()->close();
    }

    /**
     * @param string $path
     * @param int    $mode
     * @param int    $options
     *
     * @throws \Exception
     */
    public function mkdir($path, $mode, $options)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @param string $path
     * @param int    $options
     *
     * @throws \Exception
     */
    public function rmdir($path, $options)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @return bool
     */
    public function stream_flush()
    {
        return $this->getStream()->flush();
    }

    /**
     * @param int $count
     *
     * @return string
     */
    public function stream_read($count)
    {
        return $this->getStream()->read($count);
    }

    /**
     * @param $new_size
     *
     * @return bool
     */
    public function stream_truncate($new_size)
    {
        return $this->getStream()->truncate($new_size);
    }

    /**
     * @param int $cast_as
     *
     * @throws \Exception
     */
    public function stream_cast($cast_as)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @param string $path
     * @param string $mode
     * @param int    $options
     * @param string $opened_path
     *
     * @return bool
     */
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return $this->getStream()->open($path, $mode, $options, $opened_path);
    }

    /**
     * @param string $path
     * @param int    $options
     *
     * @throws \Exception
     */
    public function dir_opendir($path, $options)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @return bool
     */
    public function stream_eof()
    {
        return $this->getStream()->eof();
    }

    /**
     * @param string $data
     *
     * @return int
     */
    public function stream_write($data)
    {
        return $this->getStream()->write($data);
    }

    /**
     * @param string $path
     * @param int    $flags
     *
     * @return array
     */
    public function url_stat($path, $flags)
    {
        return $this->getStream()->stat($path, $flags);
    }

    /**
     * @param string $path
     *
     * @throws \Exception
     */
    public function unlink($path)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @param int $option
     * @param int $arg1
     * @param int $arg2
     *
     * @throws \Exception
     */
    public function stream_set_option($option, $arg1, $arg2)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @param string $path_from
     * @param string $path_to
     *
     * @throws \Exception
     */
    public function rename($path_from, $path_to)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     * @param int $operation
     *
     * @throws \Exception
     */
    public function stream_lock($operation)
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }

    /**
     *
     */
    public function dir_closedir()
    {
        throw new \Exception(sprintf('Method %s not implemented', __METHOD__));
    }
}
