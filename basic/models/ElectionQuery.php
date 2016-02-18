<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Election]].
 *
 * @see Election
 */
class ElectionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Election[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Election|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}