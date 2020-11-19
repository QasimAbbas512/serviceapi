<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PagesCredentials]].
 *
 * @see PagesCredentials
 */
class PagesCredentialsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PagesCredentials[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PagesCredentials|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
