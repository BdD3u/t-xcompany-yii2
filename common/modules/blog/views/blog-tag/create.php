<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\blog\models\BlogTag */

$this->title = 'Create Blog Tag';
$this->params['breadcrumbs'][] = ['label' => 'Blog Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
