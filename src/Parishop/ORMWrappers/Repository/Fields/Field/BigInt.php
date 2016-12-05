<?php
namespace Parishop\ORMWrappers\Repository\Fields\Field;

/**
 * Class BigInt
 * @package Parishop\ORMWrappers\Repository\Fields\Field
 * @since 1.0
 */
class BigInt extends \Parishop\ORMWrappers\Repository\Fields\Field
{
    /**
     * Field constructor.
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param string $default
     * @since 1.0
     */
    public function __construct($name, $size = 20, $null = true, $default = null)
    {
        parent::__construct($name, $size, $null, $default);
    }

}

