<?php
namespace Parishop\ORMWrappers\Repository\Fields;

/**
 * Class Field
 * @package Parishop\ORMWrappers\Repository\Fields
 * @since   1.0
 */
abstract class Field
{
    /**
     * @var string
     * @since 1.0
     */
    protected $name;

    /**
     * @var string
     * @since 1.0
     */
    protected $oldName;

    /**
     * @var string
     * @since 1.0
     */
    protected $type;

    /**
     * @var string
     * @since 1.0
     */
    protected $size;

    /**
     * @var bool
     * @since 1.0
     */
    protected $null = true;

    /**
     * @var string
     * @since 1.0
     */
    protected $default;

    /**
     * @var string
     * @since 1.0
     */
    protected $after;

    /**
     * @var bool
     * @since 1.0
     */
    protected $autoincrement = false;

    /**
     * @var bool
     * @since 1.0
     */
    protected $primary = false;

    /**
     * Field constructor.
     * @param string $name
     * @param string $size
     * @param bool   $null
     * @param string $default
     * @since 1.0
     */
    public function __construct($name, $size = null, $null = true, $default = null)
    {
        $reflectionClass = new \ReflectionClass(get_class($this));
        $this->name      = $name;
        $this->type      = strtoupper($reflectionClass->getShortName());
        $this->size      = $size;
        $this->null      = $null;
        $this->default   = $default;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function asSQL()
    {
        $size    = $this->size ? '(' . $this->size . ')' : '';
        $default = 'NULL DEFAULT NULL';
        if($this->autoincrement) {
            $default = "NOT NULL DEFAULT AUTO_INCREMENT";
        } elseif($this->default !== null) {
            if($this->default) {
                if($this->isNull()) {
                    $null = 'NULL';
                } else {
                    $null = 'NOT NULL';
                }
                if(strtoupper($this->default) === 'CURRENT_TIMESTAMP') {
                    $default = "NOT NULL DEFAULT CURRENT_TIMESTAMP";
                } else {
                    $default = $null . " DEFAULT '" . $this->default . "'";
                }
            } else {
                $default = 'NOT NULL';
            }
        }
        $after = $this->after ? ' AFTER `' . $this->after . '`' : '';

        return "`{$this->name}` {$this->type}{$size} {$default}{$after}";
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getAfter()
    {
        return $this->after;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getOldName()
    {
        return $this->oldName;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return boolean
     * @since 1.0
     */
    public function isAutoincrement()
    {
        return $this->autoincrement;
    }

    /**
     * @return boolean
     * @since 1.0
     */
    public function isNull()
    {
        return $this->null;
    }

    /**
     * @return boolean
     * @since 1.0
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @param string $after
     * @return $this
     * @since 1.0
     */
    public function setAfter($after)
    {
        $this->after = $after;

        return $this;
    }

    /**
     * @return $this
     * @since 1.0
     */
    public function setAutoincrement()
    {
        $this->autoincrement = true;

        return $this;
    }

    /**
     * @param string $default
     * @return $this
     * @since 1.0
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @param boolean $null
     * @return $this
     * @since 1.0
     */
    public function setNull($null)
    {
        $this->null = $null;

        return $this;
    }

    /**
     * @param string $oldName
     * @return $this
     * @since 1.0
     */
    public function setOldName($oldName)
    {
        $this->oldName = $oldName;

        return $this;
    }

    /**
     * @return $this
     * @since 1.0
     */
    public function setPrimary()
    {
        $this->primary = true;

        return $this;
    }

    /**
     * @param string $size
     * @return $this
     * @since 1.0
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

}

