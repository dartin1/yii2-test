<?php


use yii\helpers\Html;
use yii\grid\GridView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */

$this->title = 'Список сотрудников:';

?>
<div class="list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?
        $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'FIO',
        'Position',
            ['attribute' => 'Chief',
                'format'=>'text',
                'value'=> function ($data) {
                    return $data->getParentName($data->Chief);}
            ],
        ['class' => 'yii\grid\ActionColumn'],
    ];
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'FIO',
            'Position',
            ['attribute' => 'Chief',
                'format'=>'text',
                'value'=> function ($data) {
                    return $data->getParentName($data->Chief);}
            ],
          ]])

    ?>
</div>