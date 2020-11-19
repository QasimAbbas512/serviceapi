<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MediaPageRanking]].
 *
 * @see MediaPageRanking
 */
class MediaPageRankingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MediaPageRanking[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MediaPageRanking|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
