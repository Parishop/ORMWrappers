<?php
namespace Parishop\Tests\ORMWrappers\Repository\Fields\Field;

class BitTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Parishop\ORMWrappers\Repository\Fields\Field\Bit */
    protected $field;

    public function setUp()
    {
        $this->field = new \Parishop\ORMWrappers\Repository\Fields\Field\Bit('bit');
    }

    public function test()
    {
        $this->assertEquals('`bit` BIT(1)', (string)$this->field);
    }

}

