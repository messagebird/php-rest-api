<?php

namespace MessageBird\Objects;

/**
 * Class BaseList
 *
 * @package MessageBird\Objects
 */
class BaseList extends Base
{

    public $offset;
    public $count;
    public $totalCount;
    public $links = array (
        'first'    => null,
        'previous' => null,
        'next'     => null,
        'last'     => null,
    );

    public $items = array ();
}
