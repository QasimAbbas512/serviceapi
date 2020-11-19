<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MediaLinkPosts]].
 *
 * @see MediaLinkPosts
 */
class MediaLinkPostsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MediaLinkPosts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MediaLinkPosts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
