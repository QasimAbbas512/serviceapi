<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MediaLinks]].
 *
 * @see MediaLinks
 */
class MediaLinksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MediaLinks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MediaLinks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
