<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\link\models\LinkItem */

$this->title = 'Create Link Item';
$this->params['breadcrumbs'][] = ['label' => 'Link Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
