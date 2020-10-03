<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CompanyBranches]].
 *
 * @see CompanyBranches
 */
class CompanyBranchesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompanyBranches[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompanyBranches|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
