<?php

namespace Dez\Acl\Role;

/**
 * Class Role
 * @package Dez\Acl\Role
 */
class Role implements RoleInterface {

    /**
     * @var string
     */
    protected $name = null;

    /**
     * Role constructor.
     * @param string $name
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