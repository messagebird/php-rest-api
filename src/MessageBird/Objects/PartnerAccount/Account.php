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

    public function loadToJson()
    {
        return json_encode([
            'name' => $this->name,
        ]);
    }

    /**
     * @param mixed $object
     *
     * @return $this|void
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        if (empty($this->accessKeys)) {
            return $this;
        }

        foreach($this->accessKeys as &$item) {
            $accessKey = new AccessKey();
            $item = $accessKey->loadFromArray($item);
        }

        return $this;
    }
}
