<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>



    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'class' => 'login-form',
//        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
//            'labelOptions' => ['class' => 'col-lg-1 control-label'],
//        ],
    ]); ?>


<div class="card mb-0">
    <div class="card-body">
        <div class="text-center mb-3">
            <!--<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>-->
            <img src="<?= Yii::$app->request->baseUrl ?>/logo_image/20200827170716aaa_logo.png">
            <h5 class="mb-0">Login to your account</h5>
            <span class="d-block text-muted">Your credentials</span>
        </div>

        <div class="form-group form-group-feedback form-group-feedback-left">



                <?php //$form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <input type="text" id="loginform-username" name="LoginForm[username]" class="form-control" placeholder="Username">
                <?= Html::error($model, 'username'); ?>

                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>



        </div>

        <div class="form-group form-group-feedback form-group-feedback-left">
            <input type="password" id="loginform-password" name="LoginForm[password]" class="form-control" placeholder="Password">
            <?= Html::error($model, 'password'); ?>
            <div class="form-control-feedback">
                <i class="icon-lock2 text-muted"></i>
            </div>
        </div>

        <!--<div class="form-group d-flex align-items-center">
            <div class="form-check mb-0">
                <label class="form-check-label">
                    <input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" class="form-input-styled" checked data-fouc>
                    Remember
                </label>
            </div>-->

            <!--<a href="login_password_recover.html" class="ml-auto">Forgot password?</a>-->
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
        </div>

        <div class="form-group text-center text-muted content-divider">
            <span class="px-2">or sign in with</span>
        </div>

        <div class="form-group text-center">
            <button type="button" class="btn btn-outline bg-indigo border-indigo text-indigo btn-icon rounded-round border-2"><i class="icon-facebook"></i></button>
            <button type="button" class="btn btn-outline bg-pink-300 border-pink-300 text-pink-300 btn-icon rounded-round border-2 ml-2"><i class="icon-dribbble3"></i></button>
            <button type="button" class="btn btn-outline bg-slate-600 border-slate-600 text-slate-600 btn-icon rounded-round border-2 ml-2"><i class="icon-github"></i></button>
            <button type="button" class="btn btn-outline bg-info border-info text-info btn-icon rounded-round border-2 ml-2"><i class="icon-twitter"></i></button>
        </div>
        <!--
        <div class="form-group text-center text-muted content-divider">
            <span class="px-2">Don't have an account?</span>
        </div>

        <div class="form-group">
            <a href="#" class="btn btn-light btn-block">Sign up</a>
        </div>

        <span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
        -->
    </div>


<?php ActiveForm::end(); ?>


