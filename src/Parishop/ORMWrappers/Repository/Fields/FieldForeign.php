<?php
namespace Parishop\ORMWrappers\Repository\Fields;

class FieldForeign extends Field
{
    /**
     * @var string
     */
    protected $onUpdate = 'RESTRICT';

    /**
     * @var string
     */
    protected $onDelete = 'RESTRICT';

    /**
     * FieldForeign constructor.
     * @param string      $name
     * @param Field       $field
     * @param bool        $null
     * @param null|string $default
     */
    public function __construct($name, $field, $null = true, $default = null)
    {
        parent::__construct($name, $field->size, $null, $default);
        $this->type = $field->getType();
    }

    /**
     * @return string
     */
    public function getOnDelete()
    {
        return $this->onDelete;
    }

    /**
     * @return string
     */
    public function getOnUpdate()
    {
        return $this->onUpdate;
    }

    /**
     * @param string $onDelete
     */
    public function setOnDelete($onDelete)
    {
        if(in_array(strtoupper($onDelete), ['RESTRICT', 'CASCADE', 'SET_NULL', 'NO_ACTION'])) {
            $this->onDelete = strtoupper($onDelete);
        }
    }

    /**
     * @param string $onUpdate
     */
    public function setOnUpdate($onUpdate)
    {
        if(in_array(strtoupper($onUpdate), ['RESTRICT', 'CASCADE', 'SET_NULL', 'NO_ACTION'])) {
            $this->onUpdate = strtoupper($onUpdate);
        }
    }


}