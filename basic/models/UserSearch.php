<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
	public  $isCandidateList = false;
	public $candidatesQuery;
	public $electionId;
	
	public $addCandidateFlag = false;
	public $ids;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position', 'group', 'unique_id'], 'integer'],
            [['first_name', 'last_name', 'email', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
    	if($this->isCandidateList) {
        	$query = $this->candidatesQuery;
    	}
    	else {
    		$query = User::find();
    		if($this->addCandidateFlag) {
    			
    			$query->where(['not in', 'id', $this->ids]);
    		}
    	}
		
    	
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'position' => $this->position,
            'group' => $this->group,
            'unique_id' => $this->unique_id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
    
}
