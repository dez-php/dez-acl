<?php

namespace Dez\ACL\Common;

/**
 * Interface Predicate
 * @package Dez\Common\Common
 */
interface Predicate {

    /**
     * @param $a
     * @param $b
     * @return boolean
     */
    public function apply($a, $b);

}