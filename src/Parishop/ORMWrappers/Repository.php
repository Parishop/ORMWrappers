<?php
namespace Parishop\ORMWrappers;

/**
 * Class Repository
 * @method Entity create($data = null)
 * @method Query query()
 * @method \PHPixie\ORM\Drivers\Driver\PDO\Config config()
 * @package Parishop\ORMWrappers
 * @since   1.0
 */
class Repository extends \PHPixie\ORM\Wrappers\Type\Database\Repository
{
    protected $tableName;

    protected $oldTableName;

    /**
     * @var Repository\Fields
     */
    private $fields;

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Repository $repository
     * @since 1.0
     */
    public function __construct($repository)
    {
        parent::__construct($repository);
        $this->tableName = $this->config()->table;
    }

    /**
     * @return Repository\Fields|Repository\Fields\Field[]
     */
    public function fields()
    {
        if($this->fields === null) {
            $this->fields = new Repository\Fields($this);
            $this->fields->setFields($this->initializeFields());
        }

        return $this->fields;
    }

    public function oldTableName()
    {
        return $this->oldTableName;
    }

    public function tableName()
    {
        return $this->tableName;
    }

    /**
     * @return Repository\Fields\Field[]
     * @since 1.0
     */
    protected function initializeFields()
    {
        return [
            $this->fields()->int('id')->setPrimary()->setAutoincrement(),
            $this->fields()->bigint('bigint'),
            $this->fields()->mediumInt('mediumInt'),
            $this->fields()->smallInt('smallInt'),
            $this->fields()->tinyInt('tinyInt'),
            $this->fields()->bool('bool'),
            $this->fields()->double('double'),
            $this->fields()->decimal('decimal', -1),
            $this->fields()->float('float', -1),
            $this->fields()->char('char'),
            $this->fields()->varchar('name'),
            $this->fields()->text('text'),
            $this->fields()->longText('longText'),
            $this->fields()->mediumText('mediumText'),
            $this->fields()->tinyText('tinyText'),
            $this->fields()->timestamp('created')->setCurrentTimestamp(),
            $this->fields()->dateTime('modified')->setCurrentTimestamp()->setOnUpdateCurrentTimestamp(),
        ];
    }

}

