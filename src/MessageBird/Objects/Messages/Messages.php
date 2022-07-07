<?php

namespace MessageBird\Objects\Messages;

use MessageBird\Objects\BaseList;

class Messages extends BaseList
{
    /**
     * @var Message[]
     */
    public array $items = [];
}
