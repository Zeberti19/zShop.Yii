<?php

namespace app\models;

use yii\db\ActiveRecord;

class UsersPrivs extends ActiveRecord
{
    public function getRoles()
    {
        return $this->hasMany(UsersRoles::class,['id'=>'role_id'])->viaTable('roles_privs',['priv_id'=>'id']);
    }

    static public function tableName()
    {
        return 'privs';
    }
}