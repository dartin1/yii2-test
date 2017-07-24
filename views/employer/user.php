<?php


use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Информация:';
?>

<div class="email-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],]]); ?>

    <?= $form->field($model, 'Telephone')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+38 (999) 999 99 99',])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Skype')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Adress')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-9">
            <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
