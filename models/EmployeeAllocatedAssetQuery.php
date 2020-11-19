<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmployeeAllocatedAsset]].
 *
 * @see EmployeeAllocatedAsset
 */
class EmployeeAllocatedAssetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmployeeAllocatedAsset[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeAllocatedAsset|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
