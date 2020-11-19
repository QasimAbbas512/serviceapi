<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AssignedRole]].
 *
 * @see AssignedRole
 */
class AssignedRoleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AssignedRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AssignedRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
