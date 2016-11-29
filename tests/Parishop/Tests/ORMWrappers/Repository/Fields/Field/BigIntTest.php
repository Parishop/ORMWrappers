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

    public function testAfter()
    {
        $this->field->setAfter('id');
        $this->assertEquals('id', $this->field->getAfter());
    }

    public function testAsSQL1()
    {
        $this->assertEquals('`bigint` BIGINT(20) NULL DEFAULT NULL', $this->field->asSQL());
    }

    public function testAsSQL2()
    {
        $this->field->setNull(false);
        $this->field->setDefault('');
        $this->assertEquals('`bigint` BIGINT(20) NOT NULL', $this->field->asSQL());
    }

    public function testAsSQL3()
    {
        $this->field->setNull(false);
        $this->field->setDefault('AUTO');
        $this->assertEquals('`bigint` BIGINT(20) NOT NULL DEFAULT \'AUTO\'', $this->field->asSQL());
    }

    public function testAsSQL4()
    {
        $this->field->setDefault('AUTO');
        $this->assertEquals('`bigint` BIGINT(20) NULL DEFAULT \'AUTO\'', $this->field->asSQL());
    }

    public function testAsSQL5()
    {
        $this->field->setAutoincrement();
        $this->assertEquals('`bigint` BIGINT(20) NOT NULL DEFAULT AUTO_INCREMENT', $this->field->asSQL());
    }

    public function testAsSQL6()
    {
        $this->field->setDefault('CURRENT_TIMESTAMP');
        $this->assertEquals('`bigint` BIGINT(20) NOT NULL DEFAULT CURRENT_TIMESTAMP', $this->field->asSQL());
    }

    public function testDefault()
    {
        $this->field->setDefault(1);
        $this->assertEquals('1', $this->field->getDefault());
    }

    public function testIsAutoincrement()
    {
        $this->field->setAutoincrement();
        $this->assertTrue($this->field->isAutoincrement());
    }

    public function testIsNull()
    {
        $this->field->setNull(false);
        $this->assertFalse($this->field->isNull());
    }

    public function testIsPrimary()
    {
        $this->field->setPrimary();
        $this->assertTrue($this->field->isPrimary());
    }

    public function testName()
    {
        $this->assertEquals('bigint', $this->field->getName());
    }

    public function testOldName()
    {
        $this->field->setOldName('int');
        $this->assertEquals('int', $this->field->getOldName());
    }

    public function testSize()
    {
        $this->field->setSize(11);
        $this->assertEquals(11, $this->field->getSize());
    }

    public function testType()
    {
        $this->assertEquals('BIGINT', $this->field->getType());
    }

}

