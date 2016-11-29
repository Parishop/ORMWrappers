<?php
namespace Parishop\Tests\ORMWrappers;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Parishop\ORMWrappers\Repository */
    protected $repository;

    public function setUp()
    {
        /** @var \PHPixie\ORM\Drivers\Driver\PDO\Repository $repository */
        $repository = $this->getMock('PHPixie\ORM\Drivers\Driver\PDO\Repository', [], [], '', false);
        $this->repository = new \Parishop\ORMWrappers\Repository($repository);
    }

    public function testFieldId()
    {
        $this->assertInstanceOf('Parishop\ORMWrappers\Repository\Fields\FieldInt', $this->repository->fields()->get('id'));
    }

    public function testFields()
    {
        $this->assertInstanceOf('Parishop\ORMWrappers\Repository\Fields', $this->repository->fields());
    }

    public function testIterator()
    {
        foreach($this->repository->fields() as $field) {
            $this->assertInstanceOf('Parishop\ORMWrappers\Repository\Fields\Field', $field);
        }
    }

}
