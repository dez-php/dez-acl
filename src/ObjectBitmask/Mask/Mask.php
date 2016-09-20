<?php

namespace Dez\ACL\ObjectBitmask\Mask;

/**
 * Class Mask
 * @package Dez\ACL\ObjectBitmask\Mask
 */
class Mask extends AbstractMask {

    const MASK_VIEW = 1;
    const MASK_CREATE = 1 << 1;
    const MASK_EDIT = 1 << 2;
    const MASK_UPDATE = 1 << 3;
    const MASK_DELETE = 1 << 4;
    const MASK_MASTER = 1 << 5;
    const MASK_OWNER = 1 << 6;
    const MASK_SUPER = 1 << 31;
    
}