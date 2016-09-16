<?php

namespace Dez\ACL\Common\Exception;

/**
 * Class ACLException
 * @package Dez\Common
 */
class ACLException extends \Exception
{

    /**
     * ACLException constructor.
     * @param string $message
     * @param array $replacements
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, array $replacements = [], $code = 0, \Exception $previous = null)
    {
        $keys = array_map(function ($key) {
            return ":{$key}";
        }, array_keys($replacements));
        $values = array_values($replacements);
        $message = str_replace($keys, $values, $message);

        parent::__construct($message, $code, $previous);
    }


}