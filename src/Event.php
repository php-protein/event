<?php declare(strict_types=1);

/**
 * Event
 *
 * Generic global trait for an event emitter-listener behaviour.
 *
 * @package Protein
 * @author  "Stefano Azzolini"  <lastguest@gmail.com>
 */

namespace Protein;

abstract class Event {
    use Events;

    final public static function single($name, callable $listener) {
        return static::onSingle($name, $listener);
    }
}
