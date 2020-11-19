<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmployeeJobDtl]].
 *
 * @see EmployeeJobDtl
 */
class EmployeeJobDtlQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmployeeJobDtl[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeJobDtl|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
