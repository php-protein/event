<?php declare(strict_types=1);

/**
 * Events trait
 *
 * Add to a class for a generic, private event emitter-listener.
 *
 * @package Proteins
 * @author  "Stefano Azzolini"  <lastguest@gmail.com>
 */

namespace Proteins;

trait Events {
    protected static $_listeners = [];

    final public static function on($name, callable $listener) {
        static::$_listeners[$name][] = $listener;
    }

    final public static function onSingle($name, callable $listener) {
        static::$_listeners[$name] = [$listener];
    }

    final public static function off($name, callable $listener = null) {
        if ($listener === null) {
            unset(static::$_listeners[$name]);
        } else {
            if ($idx = \array_search($listener, static::$_listeners[$name], true)) {
                unset(static::$_listeners[$name][$idx]);
            }
        }
    }

    final public static function alias($source, $alias) {
        static::$_listeners[$alias] =& static::$_listeners[$source];
    }

    /**
     * @return array|null
     *
     * @psalm-return array<int, mixed>|null
     */
    final public static function trigger($name, ...$args) {
        if (false === empty(static::$_listeners[$name])) {
            $results = [];
            foreach (static::$_listeners[$name] as $listener) {
                $results[] = $listener(...$args);
            }
            return $results;
        };
    }

    /**
     * @return array|null
     *
     * @psalm-return array<int, mixed>|null
     */
    final public static function triggerOnce($name) {
        $res = static::trigger($name);
        unset(static::$_listeners[$name]);
        return $res;
    }
}
