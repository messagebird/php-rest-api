<?php

namespace MessageBird\Objects;

use stdClass;

/**
 * Class Base
 *
 * @package MessageBird\Objects
 */
class Base implements Jsonable
{
    /**
     * @param mixed $object
     *
     * @return self
     * @deprecated 2.2.0 No longer used by internal code, please switch to {@see self::loadFromStdclass()}
     *
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
    public function loadFromStdclass(stdClass $object): self
    {
        foreach ($object as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    /**
     * @param int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string
    {
        return json_encode($this, $flags);
    }
}
