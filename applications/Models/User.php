<?php
namespace Models;

use Pangolin\Database\ActiveRecord;
use Pangolin\Http\ISession;
use Pangolin\Http\ICookie;

/**
 * @property-read int $id
 * @property string $fullname
 * @property string $nickname
 * @property string $pageAddress
 * @property text $aboutMe
 * @property string $mail
 * @property string $password
 */
class User extends ActiveRecord
{

    protected static function GetTableName()
    {
        return 'users';
    }
    
}
