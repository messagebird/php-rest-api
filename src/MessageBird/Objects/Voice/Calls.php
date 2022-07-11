<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\BaseList;

/**
 * Class BaseList
 *
 * @package MessageBird\Objects\Voice
 */
class Calls extends BaseList
{
    /**
     * @var Call[]
     */
    public $data;

    /**
     * @var array
     */
    public $_links;

    /**
     * @var array
     */
    public $pagination;
}
