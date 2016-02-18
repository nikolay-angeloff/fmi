<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote".
 *
 * @property integer $election_id
 * @property integer $user_id
 *
 * @property User $user
 * @property Election $election
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['election_id', 'user_id'], 'required'],
            [['election_id', 'user_id'], 'integer'],
            [['election_id', 'user_id'], 'unique', 'targetAttribute' => ['election_id', 'user_id'], 'message' => 'The combination of Election ID and User ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'election_id' => 'Election ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElection()
    {
        return $this->hasOne(Election::className(), ['id' => 'election_id']);
    }

    /**
     * @inheritdoc
     * @return VoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VoteQuery(get_called_class());
    }
}
