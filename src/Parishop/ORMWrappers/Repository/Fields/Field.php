<?php
namespace Parishop\ORMWrappers\Repository\Fields;

abstract class Field
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $oldName;

    /** @var string */
    protected $type;

    /** @var string */
    protected $size;

    /** @var bool */
    protected $null = true;

    /** @var string */
    protected $default;

    /** @var string */
    protected $after;

    /** @var bool */
    protected $autoincrement = false;

    /** @var bool */
    protected $primary = false;

    /**
     * Field constructor.
     * @param string $name
     * @param string $size
     * @param bool   $null
     * @param string $default
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
     */
    public function getAfter()
    {
        return $this->after;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOldName()
    {
        return $this->oldName;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return boolean
     */
    public function isAutoincrement()
    {
        return $this->autoincrement;
    }

    /**
     * @return boolean
     */
    public function isNull()
    {
        return $this->null;
    }

    /**
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @param string $after
     * @return $this
     */
    public function setAfter($after)
    {
        $this->after = $after;

        return $this;
    }

    /**
     * @return $this
     */
    public function setAutoincrement()
    {
        $this->autoincrement = true;

        return $this;
    }

    /**
     * @param string $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @param boolean $null
     * @return $this
     */
    public function setNull($null)
    {
        $this->null = $null;

        return $this;
    }

    /**
     * @param string $oldName
     * @return $this
     */
    public function setOldName($oldName)
    {
        $this->oldName = $oldName;

        return $this;
    }

    /**
     * @return $this
     */
    public function setPrimary()
    {
        $this->primary = true;

        return $this;
    }

    /**
     * @param string $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

}

