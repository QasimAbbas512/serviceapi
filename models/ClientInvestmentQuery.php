<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ClientInvestment]].
 *
 * @see ClientInvestment
 */
class ClientInvestmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClientInvestment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClientInvestment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
