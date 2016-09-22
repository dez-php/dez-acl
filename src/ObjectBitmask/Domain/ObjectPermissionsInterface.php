<?php

namespace Dez\ACL\ObjectBitmask\Domain;

interface ObjectPermissionsInterface {

    public function grant(ObjectIdentity $objectIdentity, $mask = 0);

}