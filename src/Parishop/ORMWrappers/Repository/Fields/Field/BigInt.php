<?php
namespace Parishop\ORMWrappers\Repository\Fields\Field;

class BigInt extends \Parishop\ORMWrappers\Repository\Fields\Field
{
    /**
     * Field constructor.
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param string $default
     */
    public function __construct($name, $size = 20, $null = true, $default = null)
    {
        parent::__construct($name, $size, $null, $default);
    }

}