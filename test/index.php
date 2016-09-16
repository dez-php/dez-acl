<?php

namespace TestAcl;


use Dez\ACL\ObjectBitmask\Access\Mask;
use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Dez\ACL\RoleResourceAccess\ACL;
use Dez\ACL\RoleResourceAccess\Resource\Resource;
use Dez\ACL\RoleResourceAccess\Role\Role;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

set_exception_handler(function(\Throwable $exception){
    die('<b>' . get_class($exception) . '</b>: <i>' . $exception->getMessage() . '</b>');
});

include_once __DIR__ . '/../vendor/autoload.php';

$acl = new ACL([
    'test' => __FILE__
]);

$acl->addRole(new Role('Guest'));
$acl->addRole(new Role('Administrator'));
$acl->addRole(new Role('RegisteredUser'));

$acl->addResource(new Resource('Index'), ['login', 'logout']);
$acl->addResource(new Resource('Users'), ['item', 'edit']);

$acl->allow('RegisteredUser', 'Index', 'login');
$acl->allow('RegisteredUser', 'Users', 'edit');
$acl->allow('RegisteredUser', 'Users', 'item');
$acl->allow('Administrator', 'Index', 'login');
//$acl->deny('Guest', 'Users', 'edit');
//$acl->deny('User2', 'Index', 'logout');

$mask = new Mask();

$mask->add(Mask::MASK_DELETE);

$mask->add('edit')->add('view')->add('create');

var_dump(ObjectIdentity::createFromObject(123));

die(var_dump($mask, $mask->has(Mask::MASK_DELETE), $acl));