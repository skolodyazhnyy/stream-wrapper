<?php

namespace Bcn\Component\StreamWrapper\Stream;

interface WrapperInterface
{
    /**
     * @return mixed
     */
    public function stream_stat();

    /**
     * @param int $offset
     * @param int $whence
     */
    public function stream_seek($offset, $whence = SEEK_SET);

    /**
     * @return mixed
     */
    public function dir_rewinddir();

    /**
     * @return mixed
     */
    public function dir_readdir();

    /**
     * @return int
     */
    public function stream_tell();

    /**
     * @param string $path
     * @param int    $option
     * @param mixed  $value
     */
    public function stream_metadata($path, $option, $value);

    /**
     * @return bool
     */
    public function stream_close();

    /**
     * @param string $path
     * @param int    $mode
     * @param int    $options
     */
    public function mkdir($path, $mode, $options);

    /**
     * @param string $path
     * @param int    $options
     */
    public function rmdir($path, $options);

    /**
     * @return bool
     */
    public function stream_flush();

    /**
     * @param int $count
     */
    public function stream_read($count);

    /**
     * @param int $new_size
     */
    public function stream_truncate($new_size);

    /**
     * @param int $cast_as
     */
    public function stream_cast($cast_as);

    /**
     * @param string $path
     * @param string $mode
     * @param int    $options
     * @param string $opened_path
     */
    public function stream_open($path, $mode, $options, &$opened_path);

    /**
     * @param string $path
     * @param int    $options
     */
    public function dir_opendir($path, $options);

    /**
     * @return bool
     */
    public function stream_eof();

    /**
     * @param string $data
     */
    public function stream_write($data);

    /**
     * @param string $path
     * @param int    $flags
     */
    public function url_stat($path, $flags);

    /**
     * @param string $path
     */
    public function unlink($path);

    /**
     * @param int $option
     * @param int $arg1
     * @param int $arg2
     */
    public function stream_set_option($option, $arg1, $arg2);

    /**
     * @param string $path_from
     * @param string $path_to
     */
    public function rename($path_from, $path_to);

    /**
     * @param int $operation
     */
    public function stream_lock($operation);

    /**
     * @return bool
     */
    public function dir_closedir();
}
