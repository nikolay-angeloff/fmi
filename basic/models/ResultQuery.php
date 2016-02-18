<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Result]].
 *
 * @see Result
 */
class ResultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Result[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Result|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}