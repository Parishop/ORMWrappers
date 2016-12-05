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
    /**
     * @var \PHPixie\DefaultBundle\Builder
     * @since 1.0
     */
    protected $builder;

    /**
     * @var string
     * @since 1.0
     */
    protected $tableName;

    /**
     * @var string
     * @since 1.0
     */
    protected $oldTableName;

    /**
     * @var \PHPixie\Validate\Results\Result\Root
     * @since 1.0
     */
    protected $resultValidate;

    /**
     * @var Repository\Fields
     * @since 1.0
     */
    private $fields;

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Repository $repository
     * @param \PHPixie\DefaultBundle\Builder             $builder
     * @since 1.0
     */
    public function __construct($repository, $builder)
    {
        parent::__construct($repository);
        $this->builder   = $builder;
        $this->tableName = $this->config()->table;
    }

    /**
     * @return Repository\Fields|Repository\Fields\Field[]
     * @since 1.0
     */
    public function fields()
    {
        if($this->fields === null) {
            $this->fields = new Repository\Fields($this);
            $this->fields->setFields($this->initializeFields());
        }

        return $this->fields;
    }

    /**
     * @param array $data
     * @return bool
     * @since 1.0
     */
    public function isValid($data)
    {
        $validate  = $this->builder->components()->validate();
        $validator = $validate->validator();
        /** @var \PHPixie\Validate\Rules\Rule\Value $rule */
        $rule = $validator->rule();
        /** @var \PHPixie\Validate\Rules\Rule\Data\Document $document */
        $document = $rule->addDocument();
        $this->validateDocument($document);
        $this->resultValidate = $validator->validate($data);

        return $this->resultValidate->isValid();
    }

    /**
     * @return string
     * @since 1.0
     */
    public function oldTableName()
    {
        return $this->oldTableName;
    }

    /**
     * @return string
     * @since 1.0
     */
    public function tableName()
    {
        return $this->tableName;
    }

    /**
     * @return array
     * @since 1.0
     */
    public function validateErrors()
    {
        $errors = [];
        if($this->resultValidate instanceof \PHPixie\Validate\Results\Result\Root) {
            foreach($this->resultValidate->errors() as $error) {
                if($error instanceof \PHPixie\Validate\Errors\Error\Data\InvalidFields) {
                    $errors[] = 'Лишние данные: ' . implode(', ', $error->fields());
                }
            }
            /** @var \PHPixie\Validate\Results\Result\Field $fieldResult */
            foreach($this->resultValidate->invalidFields() as $fieldResult) {
                /** @var \PHPixie\Validate\Errors\Error $error */
                foreach($fieldResult->errors() as $error) {
                    if($error instanceof \PHPixie\Validate\Errors\Error\EmptyValue) {
                        $errors[] = $fieldResult->path() . ': Обязательно для заполнения';
                    } elseif($error instanceof \PHPixie\Validate\Errors\Error\Filter) {
                        $errors[] = $fieldResult->path() . ': Несоответствие формату';
                    } else {
                        $errors[] = $fieldResult->path() . ': ' . $error->asString();
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * @return array
     * @since 1.0
     */
    public function validateValue()
    {
        if($this->resultValidate instanceof \PHPixie\Validate\Results\Result\Root) {
            return $this->resultValidate->getValue();
        }

        return [];
    }

    /**
     * @return Repository\Fields\Field[]
     * @since 1.0
     */
    protected function initializeFields()
    {
        return [
            $this->fields()->int('id')->setPrimary()->setAutoincrement(),
        ];
    }

    /**
     * @param \PHPixie\Validate\Rules\Rule\Data\Document $document
     * @since 1.0
     */
    protected function validateDocument(\PHPixie\Validate\Rules\Rule\Data\Document $document)
    {
        $document->allowExtraFields();
    }

}

