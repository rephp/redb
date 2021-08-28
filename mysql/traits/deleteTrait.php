<?php

namespace redb\mysql\traits;

trait deleteTrait
{

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        return $this->setAction('delete')->run();
    }
}