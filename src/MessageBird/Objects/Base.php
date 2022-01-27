<?php

namespace MessageBird\Objects;

use stdClass;

/**
 * Class Base
 *
 * @package MessageBird\Objects
 */
class Base
{
    /**
     * @deprecated 2.2.0 No longer used by internal code, please switch to {@see self::loadFromStdclass()}
     * 
     * @param mixed $object
     *
     * @return self
     */
    public function loadFromArray($object)
    {
        if ($object) {
            foreach ($object as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        return $this;
    }

    /**
     * @param stdClass $object
     * @return self
     */
    public function loadFromStdclass(stdClass $object)
    {
        foreach ($object as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }
}
