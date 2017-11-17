<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;


/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Users';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:5%'],
            ],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [
                    User::STATUS_ACTIVE => 'Да',
                    User::STATUS_DELETED => 'Нет',
                ],
                'value' => function ($model, $key, $index, $column) {
                    $status = $model->{$column->attribute};
                    $active = false;

                    if (User::STATUS_ACTIVE === $status) {
                        $label = 'Да';
                        $active = true;
                    } elseif (User::STATUS_DELETED === $status) {
                        $label = 'Нет';
                    } else {
                        $label = 'Не определен';
                    }

                    $class = 'label label-' . ($active ? 'success' : 'danger');

                    return Html::tag('span', $label, ['class' => $class]);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd 00:00:00',
                ]),
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd 00:00:00',
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ],
    ]); ?>
</div>
