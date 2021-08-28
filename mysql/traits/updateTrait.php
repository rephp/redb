<?php
namespace redb\mysql\traits;

trait updateTrait
{

    public function update()
    {
        return $this->setAction('update')->run();
    }

}