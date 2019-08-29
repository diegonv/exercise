<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Posts extends Eloquent
{
    protected $collection = 'posts';
    protected $connection = 'mongodb';
}
