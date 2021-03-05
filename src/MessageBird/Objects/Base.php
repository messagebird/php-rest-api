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
    public function loadFromArray($object)
    {
        if ($object) {
            foreach ($object AS $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        return $this;
    }
}
