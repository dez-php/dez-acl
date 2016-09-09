<?php

namespace Dez\Acl;

use Dez\Acl\Collection\ObjectCollection;
use Dez\Acl\Permission\Permission;
use Dez\Acl\Permission\Predicate;
use Dez\Acl\Resource\ResourceInterface;
use Dez\Acl\Role\RoleInterface;
use Dez\Config\Config;

/**
 * Class Acl
 * @package Dez\Acl
 */
class Acl
{
    
    const ALLOW = 1;

    const DENY = 0;

    /**
     * @var ObjectCollection|null
     */
    protected $roles = null;

    /**
     * @var ObjectCollection|null
     */
    protected $resources = null;

    /**
     * @var Config
     */
    protected $config = null;

    /**
     * Acl constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = Config::factory($config);
        $this->roles = new ObjectCollection();
        $this->resources = new ObjectCollection();
    }

    /**
     * @param RoleInterface $role
     * @return $this
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles->set($role->getName(), $role);

        return $this;
    }

    /**
     * @param ResourceInterface $resource
     * @param array $permissions
     * @return $this
     */
    public function addResource(ResourceInterface $resource, array $permissions = [])
    {
        if(count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $resource->addPermission(new Permission($permission));
            }
        }

        $this->resources->set($resource->getName(), $resource);

        return $this;
    }

    /**
     * @param $role
     * @param $resource
     * @param $permission
     * @param Predicate|null $predicate
     */
    public function isAllowed($role, $resource, $permission, Predicate $predicate = null)
    {

    }

}