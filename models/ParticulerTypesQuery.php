<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ParticulerTypes]].
 *
 * @see ParticulerTypes
 */
class ParticulerTypesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ParticulerTypes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ParticulerTypes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
