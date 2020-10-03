<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AppResponse]].
 *
 * @see AppResponse
 */
class AppResponseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AppResponse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AppResponse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
