<?php

namespace app\models;

use yii\db\ActiveRecord;

class UsersRoles extends ActiveRecord
{
    public function getPrivs()
    {
        return $this->hasMany(UsersPrivs::class,['id'=>'priv_id'])->viaTable('roles_privs',['role_id'=>'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(UsersUsersRoles::class,['role_id'=>'id']);
        //return $this->hasMany(Users::class,['id'=>'user_id'])->viaTable('users_roles',['role_id'=>'id']);
    }

    static public function tableName()
    {
        return 'roles';
    }
}