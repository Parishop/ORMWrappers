<?php
namespace Parishop\ORMWrappers\Repository\Fields\Field;

class Datetime extends \Parishop\ORMWrappers\Repository\Fields\Field
{
    /**
     * @var bool
     */
    protected $currentTimestamp = false;

    /**
     * @var bool
     */
    protected $onUpdateCurrentTimestamp = false;

    /**
     * @return bool
     */
    public function isCurrentTimestamp()
    {
        return $this->currentTimestamp;
    }

    /**
     * @return bool
     */
    public function isOnUpdateCurrentTimestamp()
    {
        return $this->onUpdateCurrentTimestamp;
    }

    /**
     * @return $this
     */
    public function setCurrentTimestamp()
    {
        $this->currentTimestamp = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function setOnUpdateCurrentTimestamp()
    {
        $this->onUpdateCurrentTimestamp = true;

        return $this;
    }


}