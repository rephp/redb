<?php
namespace redb\mysql\traits;

trait insertTrait
{

    public function insert()
    {
        return $this->setAction('insert')->run();
    }

    public function insertReplace()
    {
        return $this->setAction('insert replace')->run();
    }

    public function insertIgnore()
    {
        return $this->setAction('insert ignore')->run();
    }

}