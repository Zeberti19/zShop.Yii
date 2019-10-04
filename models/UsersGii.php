<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $surname
 * @property string $patronymic
 * @property string $first_name
 *
 * @property UsersRoles[] $usersRoles
 * @property Roles[] $roles
 */
class UsersGii extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['surname', 'patronymic', 'first_name'], 'required'],
            [['id', 'surname', 'patronymic', 'first_name'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'surname' => 'Фамилия',
            'first_name' => 'Имя',
            'patronymic' => 'Отчество',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersRoles()
    {
        //TODO реализовать функцию UsersGii::getUsersRoles
        return false;
        //return $this->hasMany(UsersRoles::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        //TODO реализовать функцию UsersGii::getRoles
        return false;
        //return $this->hasMany(Roles::className(), ['id' => 'role_id'])->viaTable('users_roles', ['user_id' => 'id']);
    }
}
