<?php

namespace TestAcl;

use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;
use Dez\ACL\ObjectBitmask\Mask\Mask;
use Dez\ACL\ObjectBitmask\Repository;
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

$serialized = serialize($acl);

var_dump(
    $serialized,
    unserialize($serialized)
);

//$acl->deny('Guest', 'Users', 'edit');
//$acl->deny('User2', 'Index', 'logout');

$mask = new Mask();

$mask->add('edit')->add('view')->add('create')->add('super')->add(Mask::MASK_VIEW | Mask::MASK_MASTER);

class User {
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}

//var_dump(ObjectIdentity::createFromObject(123));

$identity = ObjectIdentity::createFromObject(new \stdClass());
$user = ObjectIdentity::createFromObject(new User(777));

$secureIdentity = ObjectIdentity::createFromObject(new \SplObjectStorage());

$objectACL = new Repository();

$objectACL->grant($identity, new User(mt_rand(10, 10000)), $mask);
$objectACL->grant($identity, new User(mt_rand(10, 10000)), Mask::MASK_SUPER);
$objectACL->grant($identity, $secureIdentity, Mask::MASK_SUPER | Mask::MASK_DELETE);
$objectACL->grant($identity, new User(mt_rand(10, 10000)), Mask::MASK_OWNER | Mask::MASK_MASTER);
$objectACL->grant($identity, new User(mt_rand(10, 10000)), Mask::MASK_UPDATE);

$objectACL->grant($user, new User(mt_rand(10, 10000)), Mask::MASK_SUPER);
$objectACL->grant($user, new User(mt_rand(10, 10000)), Mask::MASK_SUPER | Mask::MASK_DELETE);
$objectACL->grant($user, new User(mt_rand(10, 10000)), Mask::MASK_OWNER | Mask::MASK_MASTER);
$objectACL->grant($user, new User(mt_rand(10, 10000)), Mask::MASK_UPDATE);


//$data = serialize($objectACL);
///** @var $unserialized AbstractProvider */
//$unserialized = unserialize($data);

file_put_contents(__DIR__ . '/accesses.json', json_encode($objectACL, JSON_PRETTY_PRINT));

//die(var_dump($objectACL));

//die(var_dump(
//    Config::factory('c:\\usr\\php\\php.ini')->toIni()
//));


//die(var_dump($mask->has(Mask::MASK_DELETE)));