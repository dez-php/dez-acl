<?php

namespace Dez\ACL\ObjectBitmask\Access;

use Dez\ACL\ObjectBitmask\Domain\ObjectIdentity;

interface ObjectAccessInterface {

    public function grant(ObjectIdentity $objectIdentity, $mask = 0);

}