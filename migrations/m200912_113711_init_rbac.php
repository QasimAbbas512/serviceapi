<?php

use yii\db\Migration;

/**
 * Class m200912_113711_init_rbac
 */
class m200912_113711_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;
        // add "createPost" permission
        $createPost = $auth->createPermission('countries/create');
        $createPost->description = 'Create New Country';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('countries/update');
        $updatePost->description = 'Update Country Info';
        $auth->add($updatePost);

        $indexPost = $auth->createPermission('countries/index');
        $indexPost->description = 'access index';
        $auth->add($indexPost);

        $viewPost = $auth->createPermission('countries/view');
        $viewPost->description = 'access index';
        $auth->add($viewPost);

        $deletePost = $auth->createPermission('countries/delete');
        $deletePost->description = 'Delete Country Info';
        $auth->add($deletePost);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);
        $auth->addChild($author, $viewPost);
        $auth->addChild($author, $indexPost);


        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($author, $deletePost);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200912_113711_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200912_113711_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
