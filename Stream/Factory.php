<?php

namespace Bcn\Component\StreamWrapper\Stream;

use Bcn\Component\StreamWrapper\Stream;

class Factory
{
    const PROXY_CLASSNAME = 'Proxy';

    /**
     * @var Stream[]
     */
    protected $used = array();

    /**
     * @var array
     */
    protected $free = array();

    /**
     * @var Factory
     */
    protected static $instance = null;

    protected function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $id
     *
     * @return Stream|null
     */
    public function getStream($id)
    {
        if (isset($this->used[$id])) {
            return $this->used[$id];
        }

        return;
    }

    /**
     * @param string $id
     */
    public function release($id)
    {
        if (isset($this->used[$id])) {
            unset($this->used[$id]);
            $this->free[] = $id;
        }
    }

    /**
     * @param Stream $stream
     *
     * @return string
     */
    public function capture(Stream $stream)
    {
        if (empty($this->free)) {
            $this->free[] = $this->create();
        }

        $id = array_pop($this->free);
        $this->used[$id] = $stream;

        return $id;
    }

    /**
     * @return string
     */
    protected function create()
    {
        $id = uniqid('stream');

        eval(sprintf(
            'namespace %s { class %s extends \\%s {}; }',
            __NAMESPACE__,
            self::PROXY_CLASSNAME.'_'.$id,
            __NAMESPACE__.'\\'.self::PROXY_CLASSNAME
        ));

        stream_wrapper_register($id, $this->getProxyClassName($id));

        return $id;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    protected function getProxyClassName($id)
    {
        return __NAMESPACE__.'\\'.self::PROXY_CLASSNAME.'_'.$id;
    }
}
