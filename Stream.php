<?php

namespace Bcn\Component\StreamWrapper;

use Bcn\Component\StreamWrapper\Wrapper\Registry;

class Stream
{

    const INSTANCE_CLASSNAME = "Instance";

    /** @var null|string */
    protected $id = null;
    /** @var string $content */
    protected $content;
    /** @var int */
    protected $position;
    /** @var boolean */
    protected $open;

    /**
     * @param null|string $content
     */
    public function __construct($content = null) {
        $this->id       = uniqid("stream");
        $this->content  = $content;
        $this->position = -1;

        $this->register();
    }

    /**
     *
     */
    public function __destruct() {
        $this->unregister();
    }

    /**
     * @param $path
     * @param $mode
     * @param $options
     * @param $opened_path
     * @return bool
     */
    public function open($path, $mode, $options, &$opened_path) {
        if($path == $this->id . "://stream" && !$this->open) {
            $this->open = true;
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function close() {
        $this->open = false;
        return true;
    }

    /**
     * @param $offset
     * @param int $whence
     * @return int
     */
    public function seek($offset, $whence = SEEK_SET) {
        switch($whence) {
            case SEEK_CUR:
                $this->position += $offset;
                break;
            case SEEK_END:
                $this->position = $offset;
                break;
            case SEEK_SET:
                $this->position = $this->size() + $offset;
                break;
        }

        if($this->position >= $this->size()) {
            $this->position = $this->size() - 1;
        }

        return $this->position;
    }

    /**
     * @return int
     */
    public function tell() {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function flush() {
        return true;
    }

    /**
     * @param int $count
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
     * @param string $data
     * @return int
     */
    public function write($data)
    {
        $prepend = mb_substr($this->content, 0, $this->position + 1);
        $append  = mb_substr($this->content, $this->position + 1 + mb_strlen($data));

        $this->content = $prepend . $data . $append;
        return mb_strlen($data);
    }

    /**
     * @return int
     */
    public function size() {
        return mb_strlen($this->content);
    }

    /**
     * @return string
     */
    public function uri() {
        return $this->id . "://stream";
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->uri();
    }

    /**
     * @return null|string
     */
    public function content() {
        return $this->content;
    }

    /**
     *
     */
    protected function register()
    {
        Registry::register($this->id, $this);

        $namespaceName = __NAMESPACE__ . "\\Wrapper";
        eval(sprintf(
            "namespace %s { class %s extends \\%s {}; }",
            $namespaceName,
            self::INSTANCE_CLASSNAME . "_" . $this->id,
            $namespaceName . "\\" . self::INSTANCE_CLASSNAME
        ));

        stream_wrapper_register($this->id, $namespaceName . "\\" . self::INSTANCE_CLASSNAME . "_" . $this->id);
    }

    /**
     *
     */
    protected function unregister()
    {
        stream_wrapper_unregister($this->id);
        Registry::unregister($this->id);
    }

}