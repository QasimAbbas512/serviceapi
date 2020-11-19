<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Complaints]].
 *
 * @see Complaints
 */
class ComplaintsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Complaints[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Complaints|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
