<?php
namespace Parishop\Tests\ORMWrappers\Repository\Fields\Field;

class BigIntTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Parishop\ORMWrappers\Repository\Fields\Field\BigInt */
    protected $field;

    public function setUp()
    {
        $this->field = new \Parishop\ORMWrappers\Repository\Fields\Field\BigInt('bigint');
    }

    public function test()
    {
        $this->assertEquals('`bigint` BIGINT(20)', (string)$this->field);
    }

}

