<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники вашего отдела';
?>
<div class="employer-index">

    <h1 align="center"><?= Html::encode($this->title); ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?
    if ($dataProvider->count > 5) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'FIO',
                'Position',
                ['attribute' => 'Chief',
                    'format' => 'text',
                    'value' => function ($data) {
                        return $data->getParentName($data->Chief);
                    }
                ],
                ['attribute' => 'BestEmployer',
                    'value' => function ($data) {
                        return Html::a(Html::encode($data["BestEmployer"]), \yii\helpers\Url::to(['employer/setbest', 'id' => $data["id"]]));
                    },
                    'format' => 'raw',
                ],
                ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:260px;'],
                    'header' => 'Actions',
                    'template' => '{view}{update}{delete}',
                    'urlCreator' => function ($action, $model) {
                        return ($action == 'view') ? [$action, 'id' => $model['id']] : [$action, 'id' => $model['id']];
                    }
                ],
            ],
        ]);
    } else {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'FIO',
                'Position',
                ['attribute' => 'Chief',
                    'format' => 'text',
                    'value' => function ($data) {
                        return $data->getParentName($data->Chief);
                    }
                ],
                ['attribute' => 'BestEmployer',
                    'value' => function ($data) {
                        return Html::a(Html::encode($data["BestEmployer"]), \yii\helpers\Url::to(['employer/setbest', 'id' => $data["id"]]));
                    },
                    'format' => 'raw',
                ],
                ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:260px;'],
                    'header' => 'Actions',
                    'template' => '{view}{update}',
                    'urlCreator' => function ($action, $model) {
                        return ($action == 'view') ? [$action, 'id' => $model['id']] : [$action, 'id' => $model['id']];
                    }
                ],

            ],
        ]);
    }
    ?>
    <div class="form-group">
        <div class="col-lg-offset-5 col-lg-7">
            <? if ($dataProvider->count < 10)
                echo Html::a('Добавить сотрудника', ['create'], ['class' => 'btn btn-success']);
            ?>
        </div>
    </div>
</div>


