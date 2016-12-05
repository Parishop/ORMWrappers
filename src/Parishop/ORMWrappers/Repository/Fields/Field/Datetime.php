<?php
namespace Parishop\ORMWrappers\Repository\Fields\Field;

/**
 * Class Datetime
 * @package Parishop\ORMWrappers\Repository\Fields\Field
 * @since 1.0
 */
class Datetime extends \Parishop\ORMWrappers\Repository\Fields\Field
{
    /**
     * @var bool
     * @since 1.0
     */
    protected $currentTimestamp = false;

    /**
     * @var bool
     * @since 1.0
     */
    protected $onUpdateCurrentTimestamp = false;

    /**
     * @return bool
     * @since 1.0
     */
    public function isCurrentTimestamp()
    {
        return $this->currentTimestamp;
    }

    /**
     * @return bool
     * @since 1.0
     */
    public function isOnUpdateCurrentTimestamp()
    {
        return $this->onUpdateCurrentTimestamp;
    }

    /**
     * @return $this
     * @since 1.0
     */
    public function setCurrentTimestamp()
    {
        $this->currentTimestamp = true;

        return $this;
    }

    /**
     * @return $this
     * @since 1.0
     */
    public function setOnUpdateCurrentTimestamp()
    {
        $this->onUpdateCurrentTimestamp = true;

        return $this;
    }

}

