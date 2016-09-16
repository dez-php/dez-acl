<?php

namespace Dez\ACL\ObjectBitmask\Access;

/**
 * Class HierarchyMask
 * @package Dez\ACL\ObjectBitmask\Access
 */
class HierarchyMask extends Mask {

    /**
     * @var array
     */
    protected static $map = [
        parent::MASK_VIEW,
        parent::MASK_CREATE,
        parent::MASK_EDIT,
        parent::MASK_UPDATE,
        parent::MASK_DELETE,
        parent::MASK_MASTER,
        parent::MASK_OWNER,
        parent::MASK_SUPER,
    ];

}