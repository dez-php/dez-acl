<?php

namespace TestAcl;

use Dez\Acl\Acl;
use Dez\Acl\Resource\Resource;
use Dez\Acl\Role\Role;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

set_exception_handler(function(\Exception $exception){
    die(get_class($exception) . ': ' . $exception->getMessage());
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

$acl->allow('User', 'Index', 'login');
$acl->allow('User', 'Users', 'edit');
$acl->allow('User', 'Users', 'item');
$acl->allow('Admin', 'Index', 'login');
$acl->deny('Guest', 'Users', 'edit');
$acl->deny('User', 'Index', 'logout');


die(var_dump($acl));