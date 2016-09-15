<?php

namespace Dez\Acl\Permission;

/**
 * Class Mask
 * @package Dez\Acl\Permission
 */
class Mask extends AbstractMask {

    const MASK_VIEW = 1;
    const MASK_CREATE = 2;
    const MASK_EDIT = 4;
    const MASK_DELETE = 8;
    const MASK_UPDATE = 16;
    const MASK_MASTER = 32;
    const MASK_OWNER = 64;

}