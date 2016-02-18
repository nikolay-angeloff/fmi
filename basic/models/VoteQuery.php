<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Vote]].
 *
 * @see Vote
 */
class VoteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Vote[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Vote|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}