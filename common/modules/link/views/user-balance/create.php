<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\link\models\LinkUserBalance */

$this->title = 'Create Link User Balance';
$this->params['breadcrumbs'][] = ['label' => 'Link User Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-user-balance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
