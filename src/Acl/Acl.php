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
     * @var ObjectCollection|null
     */
    protected $accesses = null;

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
        $this->accesses = new ObjectCollection();
    }

    /**
     * @param RoleInterface $role
     * @return $this
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles->set($role->getRoleName(), $role);

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

        $this->resources->set($resource->getIdentifier(), $resource);

        return $this;
    }

    /**
     * @param $roleName
     * @param $resourceName
     * @param $accesses
     * @param int $state
     * @return $this
     * @throws AclException
     */
    public function setAccess($roleName, $resourceName, $accesses, $state = Acl::DENY)
    {
        if(! $this->roles->has($roleName)) {
            throw new AclException('Role with the name ":name" not found', [
                'name' => $roleName,
            ]);
        }

        if(! $this->resources->has($resourceName)) {
            throw new AclException('Resource with the name ":name" not found', [
                'name' => $resourceName,
            ]);
        }

        $accesses = ! is_array($accesses) ? [$accesses] : $accesses;

        foreach($accesses as $access) {
            if(! $this->resources->get($resourceName)->hasPermission($access)) {
                throw new AclException('Permission ":name" do not attached to resource ":resource_name"', [
                    'name' => $access,
                    'resource_name' => $resourceName,
                ]);
            }

            $accessKey = "$roleName@$resourceName::$access";
            $this->accesses[$accessKey] = $state;
        }

        return $this;
    }

    /**
     * @param $roleName
     * @param $resourceName
     * @param $permissionName
     * @return Acl
     * @throws AclException
     */
    public function allow($roleName, $resourceName, $permissionName)
    {
        return $this->setAccess($roleName, $resourceName, $permissionName, Acl::ALLOW);
    }

    /**
     * @param $roleName
     * @param $resourceName
     * @param $permissionName
     * @return Acl
     * @throws AclException
     */
    public function deny($roleName, $resourceName, $permissionName)
    {
        return $this->setAccess($roleName, $resourceName, $permissionName, Acl::DENY);
    }

    /**
     * @param $role
     * @param $resource
     * @param $permission
     * @param Predicate|null $predicate
     * @return bool
     */
    public function isAllowed($role, $resource, $permission, Predicate $predicate = null)
    {
        if($this->roles->has($role)) {
            if($this->resources->has($resource)) {
                if($this->resources->get($resource)->hasPermission($permission)) {
                    $accessKey = "$role@$resource::$permission";
                    if($this->accesses->has($accessKey)) {
                        return $this->accesses->get($accessKey);
                    }
                }
            }
        }

        return false;
    }

}