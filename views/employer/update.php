<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employer */

$this->title = 'Изменение данных сотрудника ' . $model->FIO;
?>
<div class="employer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
