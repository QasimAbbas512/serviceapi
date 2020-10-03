<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Particulers]].
 *
 * @see Particulers
 */
class ParticulersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Particulers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Particulers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
