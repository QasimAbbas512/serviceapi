<?php

namespace app\controllers;

use app\models\Employees;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin_x()
    {
        $this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user_id = Yii::$app->user->identity->getId();
            $user_info = User::findOne(['id' => $user_id,'Active'=>'Y']);
            $emp_info = Employees::findIdentity(['ID' => $user_info->EmpID]);

            Yii::$app->session->set('user_id',$user_id);
            Yii::$app->session->set('branch_id',$user_info->BranchID);
            Yii::$app->session->set('emp_name',$emp_info->FullName);

            //echo '--'.Yii::$app->session->get('user_id').'/'.Yii::$app->session->get('branch_id');
            //exit();
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('login_x', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'loginLayout2';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()) {
                $user_id = Yii::$app->user->identity->getId();
                $user_info = User::findOne(['id' => $user_id, 'Active' => 'Y']);
                $emp_info = Employees::findIdentity(['ID' => $user_info->EmpID]);

                Yii::$app->session->set('user_id', $user_id);
                Yii::$app->session->set('branch_id', $user_info->BranchID);
                Yii::$app->session->set('emp_name', $emp_info->FullName);

//                echo '--' . Yii::$app->session->get('user_id') . '/' . Yii::$app->session->get('branch_id');
//                exit();
                return $this->goHome();
            }else{
                print_r($model->getErrors());exit();
            }

        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLoginMember()
    {
        $this->layout = 'loginLayout2';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
//            if($model->login()) {
//                $user_id = Yii::$app->user->identity->getId();
//                $user_info = User::findOne(['id' => $user_id, 'Active' => 'Y']);
//                $emp_info = Employees::findIdentity(['ID' => $user_info->EmpID]);
//
//                Yii::$app->session->set('user_id', $user_id);
//                Yii::$app->session->set('branch_id', $user_info->BranchID);
//                Yii::$app->session->set('emp_name', $emp_info->FullName);
//
////                echo '--' . Yii::$app->session->get('user_id') . '/' . Yii::$app->session->get('branch_id');
////                exit();
//                return $this->goHome();
//            }

        }

        $model->password = '';
        return $this->render('login_member', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        //unset($_SESSION['user_id']);
        echo Yii::$app->session->get('user_id');
        unset($session['user_id']);
        Yii::$app->session->destroy();
        Yii::$app->user->logout();
        //echo '---'.Yii::$app->session->get('user_id');exit();
        return $this->redirect(yii::$app->user->loginUrl);
        //return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
