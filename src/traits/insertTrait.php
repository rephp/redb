<?php
namespace rephp\redb\traits;
/**
 * Trait insertTrait
 * @package rephp\redb\traits
 * @method \rephp\redb\redb setAction()
 */
trait insertTrait
{

    public function insert($data=[])
    {
        empty($data) || $this->data($data);
        return $this->setAction('insert')->run();
    }

    public function insertReplace($data=[])
    {
        empty($data) || $this->data($data);
        return $this->setAction('insertReplace')->run();
    }

    public function insertIgnore($data=[])
    {
        empty($data) || $this->data($data);
        return $this->setAction('insertIgnore')->run();
    }

    public function batchInsert($data=[])
    {
        empty($data) || $this->data($data);
        return $this->setAction('batchInsert')->run();
    }

    public function batchInsertReplace($data=[])
    {
        empty($data) || $this->data($data);
        return $this->setAction('batchInsertReplace')->run();
    }

    public function batchInsertIgnore($data=[])
    {
        empty($data) || $this->data($data);
        return $this->setAction('batchInsertIgnore')->run();
    }


}