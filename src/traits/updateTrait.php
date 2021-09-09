<?php
namespace rephp\redb\traits;
/**
 * Trait updateTrait
 * @package rephp\redb\traits
 * @method \rephp\redb\redb setAction()
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

    public function update($data=[])
    {
        empty($data) || $this->data($data);
        return $this->setAction('update')->run();
    }

}