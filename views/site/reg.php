<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $employer app\models\Employer */

$this->title = 'Регистрация';
?>

<div class="site-reg">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'form-signup',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],]]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'employer')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Employer::find()->all(), 'id', 'FIO')) ?>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-9">
            <?= Html::submitButton('ОК', ['class' => 'btn btn-primary', 'name' => 'reg-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-reg -->
