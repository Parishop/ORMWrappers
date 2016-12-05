<?php
namespace Parishop\Tests\ORMWrappers\Repository\Fields\Field;

/**
 * Class YearTest
 * @package Parishop\Tests\ORMWrappers\Repository\Fields\Field
 * @since   1.0
 */
class YearTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Parishop\ORMWrappers\Repository\Fields\Field\Year */
    protected $year;

    public function setUp()
    {
        $this->year = new \Parishop\ORMWrappers\Repository\Fields\Field\Year('year');
    }

    public function test()
    {
        $this->assertEquals('`year` YEAR', (string)$this->year);
    }

}

