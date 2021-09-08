<?php
namespace redb\traits;
/**
 * Trait updateTrait
 * @package redb\traits
 * @method \redb\redb setAction()
 */
trait updateTrait
{

    public function inc($column, $step=1)
    {
        $this->getOrmModel()->inc($column, $step);
        return $this;
    }

    public function dec($column, $step=1)
    {
        $this->getOrmModel()->dec($column, $step);
        return $this;
    }

    public function update()
    {
        return $this->setAction('update')->run();
    }

}