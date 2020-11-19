<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TeamMembers]].
 *
 * @see TeamMembers
 */
class TeamMembersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TeamMembers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TeamMembers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
