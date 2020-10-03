<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>



    <?php //$form = ActiveForm::begin([
        //'id' => 'login-form',
        //'class' => 'login-form',
//        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
//            'labelOptions' => ['class' => 'col-lg-1 control-label'],
//        ],
 //   ]); ?>


<!--end::Login Header-->
<!--begin::Login Sign in form-->
<div class="login-signin">
    <div class="mb-20">
<!--        <h3 class="opacity-40 font-weight-normal">Sign In To CRM</h3>-->
<!--        <p class="opacity-40">Enter your details to login to your account:</p>-->
        <img src="<?= Yii::$app->request->baseUrl ?>/logo_image/20200827170716aaa_logo.png">
    </div>
    <?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'class' => 'login-form form fv-plugins-bootstrap fv-plugins-framework',
    //        'fieldConfig' => [
    //            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    //            'labelOptions' => ['class' => 'col-lg-1 control-label'],
    //        ],
       ]); ?>
    <!--<form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_login_signin_form" novalidate="novalidate" method="post" action="<?= Yii::$app->request->baseUrl;?>/web/site/login2">-->
        <div class="form-group fv-plugins-icon-container">
            <!--<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="username" autocomplete="off">-->
            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" id="loginform-username" name="LoginForm[username]" placeholder="Username">
            <?= Html::error($model, 'username'); ?>
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group fv-plugins-icon-container">
            <!--<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Password" name="password">-->
            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" id="loginform-password" name="LoginForm[password]" placeholder="Password">
            <?= Html::error($model, 'password'); ?>
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
            <div class="checkbox-inline">
                <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                    <input type="checkbox" name="remember">
                    <span></span>Remember me</label>
            </div>
            <a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">Forget Password ?</a>
        </div>
        <div class="form-group text-center mt-10">
            <button id="kt_login_signin_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">Sign In</button>
        </div>
        <input type="hidden"><div></div>
    <!--</form>-->
    <?php ActiveForm::end(); ?>
    <div class="mt-10">
        <span class="opacity-40 mr-4">AAA Associates © <?= date('Y');?>. All Rights Reserved.</span>
    </div>
    <div class="mt-10 d-none">
        <span class="opacity-40 mr-4">Don't have an account yet?</span>
        <a href="javascript:;" id="kt_login_signup" class="text-white opacity-30 font-weight-normal">Sign Up</a>
    </div>
</div>
<!--end::Login Sign in form-->
<!--begin::Login Sign up form-->
<div class="login-signup">
    <div class="mb-20">
        <h3 class="opacity-40 font-weight-normal">Sign Up</h3>
        <p class="opacity-40">Enter your details to create your account</p>
    </div>
    <form class="form text-center fv-plugins-bootstrap fv-plugins-framework" id="kt_login_signup_form">
        <div class="form-group fv-plugins-icon-container">
            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Fullname" name="fullname">
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group fv-plugins-icon-container">
            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off">
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group fv-plugins-icon-container">
            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Password" name="password">
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group fv-plugins-icon-container">
            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword">
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group text-left px-8 fv-plugins-icon-container">
            <div class="checkbox-inline">
                <label class="checkbox checkbox-outline checkbox-white opacity-60 text-white m-0">
                    <input type="checkbox" name="agree">
                    <span></span>I Agree the
                    <a href="#" class="text-white font-weight-bold ml-1">terms and conditions</a>.</label>
            </div>
            <div class="form-text text-muted text-center"></div>
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group">
            <button id="kt_login_signup_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">Sign Up</button>
            <button id="kt_login_signup_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">Cancel</button>
        </div>
        <div></div></form>
</div>
<!--end::Login Sign up form-->
<!--begin::Login forgot password form-->
<div class="login-forgot">
    <div class="mb-20">
        <h3 class="opacity-40 font-weight-normal">Forgotten Password ?</h3>
        <p class="opacity-40">Enter your email to reset your password</p>
    </div>
    <form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_login_forgot_form">
        <div class="form-group mb-10 fv-plugins-icon-container">
            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off">
            <div class="fv-plugins-message-container"></div></div>
        <div class="form-group">
            <button id="kt_login_forgot_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">Request</button>
            <button id="kt_login_forgot_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">Cancel</button>
        </div>
        <div></div>
    </form>
</div>
<!--end::Login forgot password form-->


<?php //ActiveForm::end(); ?>


