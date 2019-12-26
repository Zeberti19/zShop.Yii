<?php

namespace app\models;

use yii\db\ActiveRecord;

class UsersUsersRoles extends ActiveRecord
{
    public function table()
    {
        return 'users_roles';
    }
}