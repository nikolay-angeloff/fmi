<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $email
 * @property string $password
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'user_name', 'email', 'password'], 'required'],
            [['first_name', 'last_name', 'user_name', 'email', 'password'], 'string', 'max' => 255],
            [['user_name', 'email'], 'unique', 'targetAttribute' => ['user_name', 'email'], 'message' => 'The User Name and Email must be unique.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_name' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
