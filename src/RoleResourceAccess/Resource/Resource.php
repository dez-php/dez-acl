<?php

namespace Dez\ACL\RoleResourceAccess\Resource;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\RoleResourceAccess\Access\AccessInterface;

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
    public function getResourceName()
    {
        return $this->name;
    }

    /**
     * @param AccessInterface $access
     * @return $this
     */
    public function addAccess(AccessInterface $access)
    {
        $this->permissions->set($access->getAccessName(), $access);

        return $this;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getAccess($name)
    {
        return $this->permissions->get($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasAccess($name)
    {
        return $this->permissions->has($name);
    }

}