<?php

namespace Dez\ACL\RoleResourceAccess;

use Dez\ACL\Common\Collection\ObjectCollection;
use Dez\ACL\Common\Exception\BadArgumentException;
use Dez\ACL\Common\Predicate;
use Dez\ACL\RoleResourceAccess\Access\Access;
use Dez\ACL\RoleResourceAccess\Resource\ResourceInterface;
use Dez\ACL\RoleResourceAccess\Role\RoleInterface;
use Dez\Config\Config;

/**
 * Class ACL
 * @package Dez\ACL\RoleResourceAccess
 */
class ACL
{
    
    const ALLOW = 1;

    const DENY = 0;

    const KEY_NAME_SEPARATOR = '::';

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
     * Common constructor.
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
                $resource->addAccess(new Access($permission));
            }
        }

        $this->resources->set($resource->getResourceName(), $resource);

        return $this;
    }

    /**
     * @param $roleName
     * @param $resourceName
     * @param $accesses
     * @param int $state
     * @return $this
     * @throws BadArgumentException
     */
    public function setAccess($roleName, $resourceName, $accesses, $state = ACL::DENY)
    {
        if(! $this->roles->has($roleName)) {
            throw new BadArgumentException('Role with the name ":name" not found', [
                'name' => $roleName,
            ]);
        }

        if(! $this->resources->has($resourceName)) {
            throw new BadArgumentException('Resource with the name ":name" not found', [
                'name' => $resourceName,
            ]);
        }

        $accesses = ! is_array($accesses) ? [$accesses] : $accesses;

        foreach($accesses as $access) {
            if(! $this->resources->get($resourceName)->hasAccess($access)) {
                throw new BadArgumentException('Common ":name" do not attached to resource ":resource_name"', [
                    'name' => $access,
                    'resource_name' => $resourceName,
                ]);
            }

            $accessKey = implode(static::KEY_NAME_SEPARATOR, [$roleName, $resourceName, $access]);
            $this->accesses[$accessKey] = $state;
        }

        return $this;
    }

    /**
     * @param $roleName
     * @param $resourceName
     * @param $permissionName
     * @return ACL
     */
    public function allow($roleName, $resourceName, $permissionName)
    {
        return $this->setAccess($roleName, $resourceName, $permissionName, ACL::ALLOW);
    }

    /**
     * @param $roleName
     * @param $resourceName
     * @param $permissionName
     * @return ACL
     */
    public function deny($roleName, $resourceName, $permissionName)
    {
        return $this->setAccess($roleName, $resourceName, $permissionName, ACL::DENY);
    }

    /**
     * @param $role
     * @param $resource
     * @param $access
     * @param Predicate|null $predicate
     * @return bool
     */
    public function isAllowed($role, $resource, $access, Predicate $predicate = null)
    {
        if($this->roles->has($role)) {
            if($this->resources->has($resource)) {
                if($this->resources->get($resource)->hasPermission($access)) {
                    $accessKey = implode(static::KEY_NAME_SEPARATOR, [$role, $resource, $access]);
                    if($this->accesses->has($accessKey)) {
                        $predicateResult = (null === $predicate || $predicate->apply($this->roles->get($role), $this->resources->get($resource)));
                        return $this->accesses->get($accessKey) && $predicateResult;
                    }
                }
            }
        }

        return false;
    }

}