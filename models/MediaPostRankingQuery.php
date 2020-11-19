<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MediaPostRanking]].
 *
 * @see MediaPostRanking
 */
class MediaPostRankingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MediaPostRanking[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MediaPostRanking|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
