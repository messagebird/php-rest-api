<?php

namespace MessageBird\Objects;

/**
 * Class BaseList
 *
 * @package MessageBird\Objects
 */
class BaseList
{
    public int $limit;
    public int $offset;
    public int $count;
    public int $totalCount;
    public array $links = [
        'first' => null,
        'previous' => null,
        'next' => null,
        'last' => null,
    ];

    public array $items = [];
}
