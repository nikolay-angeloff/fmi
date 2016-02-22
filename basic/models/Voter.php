<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "voter".
 *
 * @property integer $election_id
 * @property integer $group_id
 *
 * @property Group $group
 * @property Election $election
 */
class Voter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'voter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['election_id', 'group_id'], 'required'],
            [['election_id', 'group_id'], 'integer'],
            [['election_id', 'group_id'], 'unique', 'targetAttribute' => ['election_id', 'group_id'], 'message' => 'The combination of Election ID and Group ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'election_id' => 'Election ID',
            'group_id' => 'Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
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
     * @return VoterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VoterQuery(get_called_class());
    }
}
