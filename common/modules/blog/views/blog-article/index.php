<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\blog\models\BlogArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="blog-article-index" style="max-width: 100%">
    <p>
        <?= Html::a('Создать статью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id];
                },
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width: 1%;']
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return html_entity_decode(strip_tags($model->{$column->attribute}));
                }
            ],
            [
                'attribute' => 'active',
                'format' => 'raw',
                'filter' => [
                    0 => 'Нет',
                    1 => 'Да',
                ],
                'value' => function ($model, $key, $index, $column) {
                    $active = $model->{$column->attribute} === 1;
                    return Html::tag('span', $active ? 'Да' : 'Нет', ['class' => 'label label-' . ($active ? 'success' : 'danger')]);
                }
            ],
            [
                'attribute' => 'preview_content',
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\StringHelper::truncate(html_entity_decode(strip_tags($model->{$column->attribute})), 252, '...');
                }
            ],
            [
                'attribute' => 'created_at',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd 00:00:00',
                ]),
            ],
            [
                'attribute' => 'updated_at',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd 00:00:00',
                ]),
                'format' => 'html',
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{update} {copy} {delete}',
                'headerOptions' => ['style' => 'width: 5%'],
                'buttons' => [
                    'copy' => function ($url, $model) {
                       // $url = Url::to(['copy'], ['id' => 1]);

                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-copy"]);
                        return Html::a($icon, $url, []);
                    }
                ]
            ],
            // 'content:ntext',
            // 'seo_keywords',
            // 'seo_description',
            // 'created_at',
            // 'updated_at',
            // 'image_id',
            // 'blog_category_id',
            // 'user_id',
        ],
    ]); ?>
</div>
