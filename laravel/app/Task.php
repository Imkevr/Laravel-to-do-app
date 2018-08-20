<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function test()
    {
        $this->where(['id' => 1]);

        return $this;
    }
}
