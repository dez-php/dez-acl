<?php

namespace TestAcl;

use Dez\ACL\ObjectBitmask\Access\Mask;
use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Dez\ACL\RoleResourceAccess\ACL;
use Dez\ACL\RoleResourceAccess\Resource\Resource;
use Dez\ACL\RoleResourceAccess\Role\Role;
use Dez\Config\Config;

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

$mask->add('edit')->add('view')->add('create')->add('super');

//var_dump(ObjectIdentity::createFromObject(123));

$objectACL = new \Dez\ACL\ObjectBitmask\ACL();

$objectACL->registerObject(new \stdClass())->grant(ObjectIdentity::createFromObject(new \stdClass()), Mask::MASK_DELETE);

$data = serialize($objectACL);

die(var_dump($data));

die(var_dump(
    Config::factory('c:\\usr\\php\\php.ini')->toIni()
));


die(var_dump($mask->has(Mask::MASK_DELETE)));