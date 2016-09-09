<?php

namespace Dez\Acl\Permission;

/**
 * Interface Predicate
 * @package Dez\Acl\Permission
 */
interface Predicate {

    /**
     * @param $a
     * @param $b
     * @return boolean
     */
    public function apply($a, $b);

}