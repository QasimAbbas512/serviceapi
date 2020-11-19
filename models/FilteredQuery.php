<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Filtered]].
 *
 * @see Filtered
 */
class FilteredQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Filtered[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Filtered|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
