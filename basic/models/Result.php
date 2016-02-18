<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "result".
 *
 * @property integer $election_id
 * @property integer $candidate_id
 * @property integer $verification_code
 * @property integer $is_verified
 *
 * @property User $candidate
 * @property Election $election
 */
class Result extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['election_id', 'candidate_id', 'verification_code'], 'required'],
            [['election_id', 'candidate_id', 'verification_code', 'is_verified'], 'integer'],
            [['verification_code'], 'unique'],
            [['election_id', 'candidate_id'], 'unique', 'targetAttribute' => ['election_id', 'candidate_id'], 'message' => 'The combination of Election ID and Candidate ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'election_id' => 'Election ID',
            'candidate_id' => 'Candidate ID',
            'verification_code' => 'Verification Code',
            'is_verified' => 'Is Verified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidate()
    {
        return $this->hasOne(User::className(), ['id' => 'candidate_id']);
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
     * @return ResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResultQuery(get_called_class());
    }
}
