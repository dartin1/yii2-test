<?php


use yii\helpers\Html;
use leandrogehlen\treegrid\TreeGrid;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */

$this->title = 'List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?=
    TreeGrid::widget([
            'dataProvider' => $dataProvider,
            'keyColumnName' => 'id',
            'showOnEmpty' => FALSE,
            'parentColumnName' => 'Chief',
            'columns' => [
                [
                    'attribute' => 'FIO',
                    'value' => function (\app\models\Employer $data) {
                        return Html::a(Html::encode($data->FIO), \yii\helpers\Url::toRoute(['employer/view', 'id' => $data->id]));
                    },
                    'format' => 'raw',
                ],
            ],
        ]
    );
    ?>

</div>