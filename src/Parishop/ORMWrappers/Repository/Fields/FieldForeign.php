<?php
namespace Parishop\ORMWrappers\Repository\Fields;

/**
 * Class FieldForeign
 * @package Parishop\ORMWrappers\Repository\Fields
 * @since 1.0
 */
class FieldForeign extends Field
{
    /**
     * @var string
     * @since 1.0
     */
    protected $onUpdate = 'RESTRICT';

    /**
     * @var string
     * @since 1.0
     */
    protected $onDelete = 'RESTRICT';

    /**
     * FieldForeign constructor.
     * @param string      $name
     * @param Field       $field
     * @param bool        $null
     * @param null|string $default
     * @since 1.0
     */
    public function __construct($name, $field, $null = true, $default = null)
    {
        parent::__construct($name, $field->size, $null, $default);
        $this->type = $field->getType();
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getOnDelete()
    {
        return $this->onDelete;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getOnUpdate()
    {
        return $this->onUpdate;
    }

    /**
     * @param string $onDelete
     * @since 1.0
     */
    public function setOnDelete($onDelete)
    {
        if(in_array(strtoupper($onDelete), ['RESTRICT', 'CASCADE', 'SET_NULL', 'NO_ACTION'])) {
            $this->onDelete = strtoupper($onDelete);
        }
    }

    /**
     * @param string $onUpdate
     * @since 1.0
     */
    public function setOnUpdate($onUpdate)
    {
        if(in_array(strtoupper($onUpdate), ['RESTRICT', 'CASCADE', 'SET_NULL', 'NO_ACTION'])) {
            $this->onUpdate = strtoupper($onUpdate);
        }
    }

}

