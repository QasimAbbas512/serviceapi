<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SocialMedias]].
 *
 * @see SocialMedias
 */
class SocialMediasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SocialMedias[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SocialMedias|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
