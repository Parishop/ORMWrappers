<?php
namespace Parishop\ORMWrappers\Repository;

class Fields extends \ArrayObject
{
    /** @var \Parishop\ORMWrappers\Repository */
    protected $repository;

    /**
     * Fields constructor.
     * @param \Parishop\ORMWrappers\Repository $repository
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
     */
    public function asArray()
    {
        return $this->getIterator();
    }

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
     */
    public function bigInt($name, $size = 20, $null = true, $default = null)
    {
        return $this->buildField($name, 'bigint', $size, $null, $default);
    }

    /**
     * @param string $name
     * @param bool   $default
     * @return Fields\Field\TinyInt
     */
    public function bool($name, $default = false)
    {
        return $this->buildField($name, 'tinyint', 1, false, (int)$default);
    }

    /**
     * @param string $fieldName
     * @return string
     * @throws Exception
     */
    public function changeSQL($fieldName)
    {
        $field = $this->get($fieldName);
        if(($oldName = $field->getOldName()) === null) {
            $oldName = $fieldName;
        }

        return 'ALTER TABLE `' . $this->databaseName . '`.`' . $this->tableName . '` CHANGE COLUMN `' . $oldName . '` ' . $field->asSQL() . ';';
    }

    /**
     * @param string $name
     * @param int    $size
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Char
     */
    public function char($name, $size = 1, $null = true, $default = null)
    {
        return $this->buildField($name, 'char', $size, $null, $default);
    }

    /**
     * @param string $fieldName
     * @return string
     * @throws Exception
     */
    public function createSQL($fieldName)
    {
        $field = $this->get($fieldName);

        return 'ALTER TABLE `' . $this->databaseName . '`.`' . $this->tableName . '` ADD COLUMN ' . $field->asSQL() . ';';
    }

    /**
     * @param string $name
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Date
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
     */
    public function double($name, $size = null, $point = null, $null = true, $default = null)
    {
        if(is_int($size)) {
            $size = '(' . (int)$size . ',' . (int)$point . ')';
        }

        return $this->buildField($name, 'double', $size, $null, $default);
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public function dropSQL($fieldName)
    {
        return 'ALTER TABLE `' . $this->databaseName . '`.`' . $this->tableName . '` DROP COLUMN `' . $fieldName . '`;';
    }

    /**
     * @param string $name
     * @param array  $values
     * @param bool   $null
     * @param string $default
     * @return Fields\Field\Enum
     */
    public function enum($name, array $values, $null = true, $default = null)
    {
        return $this->buildField($name, 'enum', '(' . implode(',', $values) . ')', $null, $default);
    }

    /**
     * @param string $fieldName
     * @return bool
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
     */
    public function get($fieldName)
    {
        return $this->offsetGet($fieldName);
    }

    /**
     * @param string $name
     * @param int    $size
     * @return Fields\Field\Int
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
     */
    public function set($name, array $values, $null = true, $default = null)
    {
        return $this->buildField($name, 'set', '(' . implode(',', $values) . ')', $null, $default);
    }

    /**
     * @param Fields\Field[] $fields
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
     */
    protected function buildFieldForeign($name, $field, $null = true, $default = null)
    {
        return new Fields\FieldForeign($name, $field, $null, $default);
    }
}

