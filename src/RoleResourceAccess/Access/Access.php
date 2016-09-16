<?php

namespace Dez\ACL\RoleResourceAccess\Access;

/**
 * Class Access
 * @package Dez\ACL\RoleResourceAccess\Access
 */
class Access implements AccessInterface {

    /**
     * @var string
     */
    protected $name;

    /**
     * Common constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAccessName()
    {
        return $this->name;
    }


}