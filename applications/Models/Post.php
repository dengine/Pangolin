<?php

namespace Models;

use Pangolin\Database\ActiveRecord;

class Post extends ActiveRecord
{
    protected static function GetTableName()
    {
        return 'posts';
    }
}

