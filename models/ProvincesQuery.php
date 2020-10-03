<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Provinces]].
 *
 * @see Provinces
 */
class ProvincesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Provinces[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Provinces|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
