<?php

namespace MessageBird\Objects\PartnerAccount;

use MessageBird\Objects\Base;

class Account extends Base
{
    public $id;

    public $name;

    public $email;

    public $accessKeys = [];

    public $signingKey;
}
