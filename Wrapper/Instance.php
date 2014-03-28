<?php

namespace Bcn\Component\StreamWrapper\Wrapper;

use Bcn\Component\StreamWrapper\Stream;

abstract class Instance implements WrapperInterface {

    /** @var Stream */
    protected $stream;

    /**
     * @return Stream
     */
    protected function stream() {
        if($this->stream === null) {
            $id = str_replace(__CLASS__ . "_", '', get_class($this));
            $this->stream = Registry::registry($id);
        }
        return $this->stream;
    }

    /**
     * @throws \Exception
     */
    public function stream_stat()
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @param int $offset
     * @param int $whence
     * @return int
     */
    public function stream_seek($offset, $whence = SEEK_SET)
    {
        return $this->stream()->seek($offset, $whence);
    }

    /**
     * @return mixed|void
     * @throws \Exception
     */
    public function dir_rewinddir()
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @throws \Exception
     */
    public function dir_readdir()
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     *
     */
    public function stream_tell()
    {
        return $this->stream()->tell();
    }

    /**
     * @param string $path
     * @param int $option
     * @param mixed $value
     * @throws \Exception
     */
    public function stream_metadata($path, $option, $value)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     *
     */
    public function stream_close()
    {
        return $this->stream()->close();
    }

    /**
     * @param string $path
     * @param int $mode
     * @param int $options
     * @throws \Exception
     */
    public function mkdir($path, $mode, $options)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @param string $path
     * @param int $options
     * @throws \Exception
     */
    public function rmdir($path, $options)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @return bool
     */
    public function stream_flush()
    {
        return $this->stream()->flush();
    }

    /**
     * @param int $count
     * @return string
     */
    public function stream_read($count)
    {
        return $this->stream()->read($count);
    }

    /**
     * @param $new_size
     * @return bool
     */
    public function stream_truncate($new_size)
    {
        return $this->stream()->truncate($new_size);
    }

    /**
     * @param int $cast_as
     * @throws \Exception
     * @return null
     */
    public function stream_cast($cast_as)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @param string $path
     * @param string $mode
     * @param int $options
     * @param string $opened_path
     * @return bool
     */
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return $this->stream()->open($path, $mode, $opened_path, $opened_path);
    }

    /**
     * @param string $path
     * @param int $options
     * @throws \Exception
     */
    public function dir_opendir($path, $options)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @return boolean
     */
    public function stream_eof()
    {
        return $this->stream()->eof();
    }

    /**
     * @param string $data
     * @return int
     */
    public function stream_write($data)
    {
        return $this->stream()->write($data);
    }

    /**
     * @param string $path
     * @param int $flags
     * @throws \Exception
     */
    public function url_stat($path, $flags)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    public function unlink($path)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @param int $option
     * @param int $arg1
     * @param int $arg2
     * @throws \Exception
     */
    public function stream_set_option($option, $arg1, $arg2)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @param string $path_from
     * @param string $path_to
     * @throws \Exception
     */
    public function rename($path_from, $path_to)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     * @param int $operation
     * @throws \Exception
     */
    public function stream_lock($operation)
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

    /**
     *
     */
    public function dir_closedir()
    {
        throw new \Exception(sprintf("Method %s not implemented", __METHOD__));
    }

}