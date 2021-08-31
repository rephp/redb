<?php
namespace redb\mysql\traits;
/**
 * Trait insertTrait
 * @package redb\mysql\traits
 * @method \redb\mysql\mysql setAction()
 */
trait insertTrait
{

    public function insert()
    {
        return $this->setAction('insert')->run();
    }

    public function insertReplace()
    {
        return $this->setAction('insertReplace')->run();
    }

    public function insertIgnore()
    {
        return $this->setAction('insertIgnore')->run();
    }

}