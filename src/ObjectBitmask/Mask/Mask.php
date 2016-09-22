<?php

namespace Dez\ACL\ObjectBitmask\Mask;

/**
 * Class Mask
 * @package Dez\ACL\ObjectBitmask\Mask
 */
class Mask extends AbstractMask {

    const MASK_VIEW = 1;
    const MASK_CREATE = 2;
    const MASK_EDIT = 4;
    const MASK_UPDATE = 8;
    const MASK_DELETE = 16;
    const MASK_MASTER = 32;
    const MASK_OWNER = 64;
    const MASK_SUPER = 128;
    
}