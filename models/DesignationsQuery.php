<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Designations]].
 *
 * @see Designations
 */
class DesignationsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Designations[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Designations|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
