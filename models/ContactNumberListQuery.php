<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ContactNumberList]].
 *
 * @see ContactNumberList
 */
class ContactNumberListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ContactNumberList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ContactNumberList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
