<?php

namespace MessageBird\Objects;

/**
 * Class Base
 *
 * @package MessageBird\Objects
 */
class Base
{
    /**
     * @param mixed $object
     *
     * @return $this
     */
    public function loadFromArray($object): self
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
}
