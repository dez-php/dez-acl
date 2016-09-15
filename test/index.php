<?php

namespace TestAcl;

use Dez\Acl\Acl;
use Dez\Acl\Permission\Mask;
use Dez\Acl\Resource\Resource;
use Dez\Acl\Role\Role;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

set_exception_handler(function(\Exception $exception){
    die('<b>' . get_class($exception) . '</b>: <i>' . $exception->getMessage() . '</b>');
});

include_once __DIR__ . '/../vendor/autoload.php';

$acl = new Acl([
    'test' => __FILE__
]);

$acl->addRole(new Role('Guest'));
$acl->addRole(new Role('Admin'));
$acl->addRole(new Role('User'));

$acl->addResource(new Resource('Index'), ['login', 'logout']);
$acl->addResource(new Resource('Users'), ['item', 'edit']);

//$acl->allow('User', 'Index', 'login');
//$acl->allow('User', 'Users', 'edit');
//$acl->allow('User', 'Users', 'item');
//$acl->allow('Admin', 'Index', 'login');
//$acl->deny('Guest', 'Users', 'edit');
//$acl->deny('User2', 'Index', 'logout');

$mask = new Mask();

$mask->add(Mask::MASK_DELETE);

$mask->add('edit')->add('view')->add('create');

die(var_dump($mask, $mask->has(Mask::MASK_DELETE), $acl));