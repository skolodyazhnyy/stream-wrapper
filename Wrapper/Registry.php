<?php

namespace Bcn\Component\StreamWrapper\Wrapper;

use Bcn\Component\StreamWrapper\Stream;

class Registry {

    /** @var Stream[] */
    protected static $register = array();

    /**
     * @param $id
     * @param Stream $instance
     */
    public static function register($id, Stream $instance) {
        self::$register[$id] = $instance;
    }

    /**
     * @param string $id
     */
    public static function unregister($id) {
        unset(self::$register[$id]);
    }

    /**
     * @param string $id
     * @return Stream
     * @throws \Exception
     */
    public static function registry($id) {
        if(!isset(self::$register[$id])) {
            throw new \Exception(sprintf('Stream %s not registered', $id));
        }

        return self::$register[$id];
    }

}