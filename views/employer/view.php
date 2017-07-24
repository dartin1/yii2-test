<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employer */

$this->title = $model->FIO;
?>
<div class="employer-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'FIO',
            'Position',
            ['attribute' => 'Chief',
                'format'=>'text',
                'value'=> $model->getParentName($model->Chief)
            ],
        ],
    ]) ?>

</div>
