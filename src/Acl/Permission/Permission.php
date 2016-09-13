<?php

namespace Dez\Acl\Permission;

/**
 * Class Permission
 * @package Dez\Acl\Permission
 */
class Permission implements PermissionInterface {

    /**
     * @var string
     */
    protected $name;

    /**
     * Permission constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}