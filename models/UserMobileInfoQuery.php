<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserMobileInfo]].
 *
 * @see UserMobileInfo
 */
class UserMobileInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserMobileInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserMobileInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
