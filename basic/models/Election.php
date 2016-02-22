<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "election".
 *
 * @property integer $id
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property integer $is_active
 * @property string $created_at
 *
 * @property Candidate[] $candidates
 * @property User[] $users
 * @property Result[] $results
 * @property Vote[] $votes
 * @property User[] $users0
 ** @property Voter[] $voters
 * @property Group[] $groups
 */
class Election extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'election';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'is_active'], 'required'],
            [['start_date', 'end_date', 'created_at'], 'safe'],
            [['is_active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        	[['start_date', 'end_date'], function ($attribute, $params) {
        		if (strtotime($this->end_date) <= strtotime($this->start_date)) {
       				$this->addError('start_date', 'The dates are not set correctly!');
       				$this->addError('end_date', 'The dates are not set correctly!');
       			}
       		}],
        	
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates()
    {
        return $this->hasMany(Candidate::className(), ['election_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('candidate', ['election_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResults()
    {
        return $this->hasMany(Result::className(), ['election_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Vote::className(), ['election_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
    	return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('vote', ['election_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoters()
    {
    	return $this->hasMany(Voter::className(), ['election_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
    	return $this->hasMany(Group::className(), ['id' => 'group_id'])->viaTable('voter', ['election_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ElectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ElectionQuery(get_called_class());
    }
}
