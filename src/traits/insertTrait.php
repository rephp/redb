<?php
namespace redb\traits;
/**
 * Trait insertTrait
 * @package redb\traits
 * @method \redb\redb setAction()
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

    public function batchInsert()
    {
        return $this->setAction('batchInsert')->run();
    }

    public function batchInsertReplace()
    {
        return $this->setAction('batchInsertReplace')->run();
    }

    public function batchInsertIgnore()
    {
        return $this->setAction('batchInsertIgnore')->run();
    }


}