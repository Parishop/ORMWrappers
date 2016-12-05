<?php
namespace Parishop\ORMWrappers\Repository;

/**
 * Class Fields
 * @package Parishop\ORMWrappers\Repository
 * @since   1.0
 */
class Fields extends \ArrayObject
{
    /**
     * @var \Parishop\ORMWrappers\Repository
     * @since 1.0
     */
    protected $repository;

    /**
     * Fields constructor.
     * @param \Parishop\ORMWrappers\Repository $repository
     * @since 1.0
     */
    public function __construct(\Parishop\ORMWrappers\Repository $repository)
    {
        $this->repository = $repository;
        /** @var \PHPixie\ORM\Drivers\Driver\PDO\Config $config */
        $config = $this->repository->config();
        /** @var \PHPixie\Slice\Type\ArrayData\Slice $connectionConfig */
        $connectionConfig   = $this->repository->connection()->config();
        $this->databaseName = $connectionConfig->get('database', 'localhost');
        $this->tableName    = $config->table;
    }

    /**
     * @return Fields\Field[]
     * @since 1.0
     */
    public function asArray()
    {
        return $this->getIterator();
    }

    /**
     * @param string $separator
     * @param string $eol
     * @return string
     * @since 1.0
     */
    public function asSQL($separator = ',', $eol = PHP_EOL)
    {
        $sql = [];
        foreach($this->asArray() as $field) {
            $sql[] = $field->asSQL();
        }

        return implode($separator . $eol, $sql);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\BigInt
     * @since 1.0
     */
    public function bigInt($name, $size = 20, $null = true, $default = null)
    {
        return $this->buildField($name, 'bigint', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $default
     * @return Fields\Field\TinyInt
     * @since 1.0
     */
    public function bool($name, $default = false)
    {
        return $this->buildField($name, 'tinyint', 1, false, (int)$default);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Char
     * @since 1.0
     */
    public function char($name, $size = 1, $null = true, $default = null)
    {
        return $this->buildField($name, 'char', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Date
     * @since 1.0
     */
    public function date($name, $null = false, $default = null)
    {
        return $this->buildField($name, 'date', null, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Datetime
     * @since 1.0
     */
    public function datetime($name, $null = false, $default = null)
    {
        return $this->buildField($name, 'datetime', null, $null, $default);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param int    $point
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Decimal
     * @since 1.0
     */
    public function decimal($name, $size = 10, $point = 0, $null = true, $default = null)
    {
        if(is_int($size)) {
            $size = '(' . (int)$size . ',' . (int)$point . ')';
        }

        return $this->buildField($name, 'decimal', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param int    $point
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Double
     * @since 1.0
     */
    public function double($name, $size = null, $point = null, $null = true, $default = null)
    {
        if(is_int($size)) {
            $size = '(' . (int)$size . ',' . (int)$point . ')';
        }

        return $this->buildField($name, 'double', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param array  $values
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Enum
     * @since 1.0
     */
    public function enum($name, array $values, $null = true, $default = null)
    {
        return $this->buildField($name, 'enum', '(' . implode(',', $values) . ')', $null, $default);
    }

    /**
     * @param string $fieldName
     * @return bool
     * @since 1.0
     */
    public function exists($fieldName)
    {
        return $this->offsetExists($fieldName);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param int    $point
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Float
     * @since 1.0
     */
    public function float($name, $size = null, $point = null, $null = true, $default = null)
    {
        if(is_int($size)) {
            $size = '(' . (int)$size . ',' . (int)$point . ')';
        }

        return $this->buildField($name, 'float', $size, $null, $default);
    }

    /**
     * @param string $modelName
     * @param string $name
     * @param bool   $null
     * @param mixed  $default
     * @return Fields\Field\BigInt
     * @since 1.0
     */
    public function foreign($modelName, $name = null, $null = true, $default = null)
    {
        /** @var \Parishop\ORMWrappers\Repository $repository */
        $repository = $this->repository->databaseModel()->repository('abacPolicy');
        $field      = $repository->fields()->get('id');
        if($name === null) {
            $name = $modelName . 'Id';
        }

        return $this->buildFieldForeign($name, $field, $null, $default);
    }

    /**
     * @param string $fieldName
     * @return Fields\Field
     * @since 1.0
     */
    public function get($fieldName)
    {
        return $this->offsetGet($fieldName);
    }

    /**
     * @param string $name
     * @param int    $size
     * @return Fields\Field\Int
     * @since 1.0
     */
    public function id($name = 'id', $size = 11)
    {
        $field = $this->buildField($name, 'int', $size);
        $field->setAutoincrement();
        $field->setPrimary();

        return $field;
    }

    /**
     * @param string $name
     * @param int    $size
     * @return Fields\Field\BigInt
     * @since 1.0
     */
    public function idBigInt($name = 'id', $size = 20)
    {
        $field = $this->buildField($name, 'bigint', $size);
        $field->setAutoincrement();
        $field->setPrimary();

        return $field;
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\Int
     * @since 1.0
     */
    public function int($name, $size = 11, $null = true, $default = null)
    {
        return $this->buildField($name, 'int', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\LongText
     */
    public function longText($name, $null = true, $default = null)
    {
        return $this->buildField($name, 'longText', null, $null, $default);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\MediumInt
     * @since 1.0
     */
    public function mediumInt($name, $size = 9, $null = true, $default = null)
    {
        return $this->buildField($name, 'mediumInt', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\MediumText
     * @since 1.0
     */
    public function mediumText($name, $null = true, $default = null)
    {
        return $this->buildField($name, 'mediumText', null, $null, $default);
    }

    /**
     * @param string $name
     * @param array  $values
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Set
     * @since 1.0
     */
    public function set($name, array $values, $null = true, $default = null)
    {
        return $this->buildField($name, 'set', '(' . implode(',', $values) . ')', $null, $default);
    }

    /**
     * @param Fields\Field[] $fields
     * @since 1.0
     */
    public function setFields($fields)
    {
        $after = $current = $primary = null;
        foreach($fields as $field) {
            if($current === null) {
                $current = $field;
            }
            if($field->isPrimary()) {
                $primary = $field;
            }
            $field->setAfter($after);
            $this->offsetSet($field->getName(), $field);
            $after = $field->getName();
        }
        if($primary === null) {
            $this->offsetSet('id', $this->id());
            $current->setAfter('id');
        }
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\SmallInt
     * @since 1.0
     */
    public function smallInt($name, $size = 6, $null = true, $default = null)
    {
        return $this->buildField($name, 'smallInt', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\Text
     * @since 1.0
     */
    public function text($name, $null = true, $default = null)
    {
        return $this->buildField($name, 'text', null, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Time
     * @since 1.0
     */
    public function time($name, $null = false, $default = null)
    {
        return $this->buildField($name, 'time', null, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Timestamp
     * @since 1.0
     */
    public function timestamp($name = 'created', $null = false, $default = 'CURRENT_TIMESTAMP')
    {
        return $this->buildField($name, 'timestamp', null, $null, $default);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\TinyInt
     * @since 1.0
     */
    public function tinyInt($name, $size = 4, $null = true, $default = null)
    {
        return $this->buildField($name, 'tinyInt', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param int    $default
     * @return Fields\Field\TinyText
     * @since 1.0
     */
    public function tinyText($name, $null = true, $default = null)
    {
        return $this->buildField($name, 'tinyText', null, $null, $default);
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Varchar
     * @since 1.0
     */
    public function varchar($name, $size = 255, $null = true, $default = null)
    {
        return $this->buildField($name, 'varchar', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param string $type
     * @param string $size
     * @param bool   $null
     * @param string $default
     * @return Fields\Field
     * @since 1.0
     */
    protected function buildField($name, $type, $size = null, $null = true, $default = null)
    {
        $className = 'Parishop\ORMWrappers\Repository\Fields\Field\\' . ucfirst(strtolower($type));
        if(!class_exists($className)) {
            return new Fields\Field\Varchar($name, 255, true, null);
        }

        return new $className($name, $size, $null, $default);
    }

    /**
     * @param string                                        $name
     * @param \Parishop\ORMWrappers\Repository\Fields\Field $field
     * @param bool                                          $null
     * @param string                                        $default
     * @return Fields\Field
     * @since 1.0
     */
    protected function buildFieldForeign($name, $field, $null = true, $default = null)
    {
        return new Fields\FieldForeign($name, $field, $null, $default);
    }

}

