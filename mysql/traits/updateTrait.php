<?php
namespace redb\mysql\traits;
/**
 * Trait updateTrait
 * @package redb\mysql\traits
 * @method \redb\mysql\mysql setAction()
 */
trait updateTrait
{

    public function update()
    {
        return $this->setAction('update')->run();
    }

}