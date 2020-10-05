<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JobPackets]].
 *
 * @see JobPackets
 */
class JobPacketsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JobPackets[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JobPackets|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
