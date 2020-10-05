<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JobPacketDtl]].
 *
 * @see JobPacketDtl
 */
class JobPacketDtlQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JobPacketDtl[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JobPacketDtl|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
