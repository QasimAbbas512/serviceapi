<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProjectGallery]].
 *
 * @see ProjectGallery
 */
class ProjectGalleryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectGallery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectGallery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
