<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Candidate]].
 *
 * @see Candidate
 */
class CandidateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Candidate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Candidate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}