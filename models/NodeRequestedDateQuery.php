<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[NodeRequestedDate]].
 *
 * @see NodeRequestedDate
 */
class NodeRequestedDateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return NodeRequestedDate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return NodeRequestedDate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
