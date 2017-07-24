<?php


use yii\helpers\Html;
use leandrogehlen\treegrid\TreeGrid;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */

$this->title = 'Список сотрудников:';

?>
<div class="list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?=

    \yii\grid\GridView::widget(['dataProvider' => $dataProvider,
            //'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
            'rowOptions' => function ($model, $key, $index, $grid) {
                if ($model->Chief == 0)
                    return ['style' => 'background-color:#FFEBCD;'];
                if ($model->Chief == 1)
                    return ['style' => 'background-color:#F0FFFF;'];
                if ($model->Chief == 2)
                    return ['style' => 'background-color:#F5F5DC;'];
                if ($model->Chief == 3)
                    return ['style' => 'background-color:#EEE9E9;'];
                if ($model->Chief == 4)
                    return ['style' => 'background-color:#CDC1C5;'];
            },
            'columns' => [
                'id',
                ['attribute' => 'Просмотр',
                    'value' => function ($data) {
                        return Html::a(Html::encode('+'), \yii\helpers\Url::toRoute(['site/tree', 'id' => $data->id]));
                    },
                    'options' => ['style' => 'width: 65px; max-width: 65px;'],
                    'contentOptions' => ['style' => 'width: 65px; max-width: 65px;'],
                    'format' => 'raw'],
                [
                    'attribute' => 'FIO',
                    'value' => function ($data) {
                        return Html::a(Html::encode($data->FIO), \yii\helpers\Url::toRoute(['employer/view', 'id' => $data->id]));
                    },
                    'format' => 'raw',
                ],
            ]
        ]
    );
    ?>

</div>