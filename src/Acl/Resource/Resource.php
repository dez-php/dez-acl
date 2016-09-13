<?php

namespace Dez\Acl\Resource;

use Dez\Acl\Collection\ObjectCollection;
use Dez\Acl\Permission\PermissionInterface;

/**
 * Class Resource
 * @package Dez\Acl\Resource
 */
class Resource implements ResourceInterface {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ObjectCollection
     */
    protected $permissions = null;

    /**
     * Resource constructor.
     * @param string $name
     * @param array $permissions
     */
    public function __construct($name, array $permissions = [])
    {
        $this->permissions = new ObjectCollection();
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param PermissionInterface $permission
     * @return $this
     */
    public function addPermission(PermissionInterface $permission)
    {
        $this->permissions->set($permission->getName(), $permission);

        return $this;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getPermission($name)
    {
        return $this->permissions->get($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasPermission($name)
    {
        return $this->permissions->has($name);
    }


}