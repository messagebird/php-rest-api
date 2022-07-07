<?php

namespace MessageBird\Objects;

use stdClass;

/**
 * Class Base
 *
 * @package MessageBird\Objects
 */
class Base implements Arrayable
{
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
     * @return array
     */
    public function toArray(): array
    {
        return (array)$this;
    }
}
