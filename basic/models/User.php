<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $first_name
 * @property integer $last_name
 * @property string $email
 * @property integer $position
 * @property integer $group
 * @property integer $unique_id
 * @property integer $created_at
 *
 * @property Group $group0
 * @property Position $position0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'position', 'group', 'unique_id'], 'required'],
            [['position', 'group', 'unique_id'], 'integer'],
        	[['created_at'], 'safe'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
        	[['email'], 'unique'],
        	[['unique_id'], 'unique'],
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
            'email' => 'Email',
            'position' => 'Position',
            'group' => 'Group',
        	'position0.title' => 'Position',
        	'group0.title' => 'Group',
            'unique_id' => 'Unique ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup0()
    {
        return $this->hasOne(Group::className(), ['id' => 'group']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition0()
    {
        return $this->hasOne(Position::className(), ['id' => 'position']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
