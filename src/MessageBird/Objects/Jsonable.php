<?php

namespace MessageBird\Objects;

interface Jsonable
{
    /**
     * Convert the object to its JSON representation.
     *
     * @param int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string;
}
