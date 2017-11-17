<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/** @var User $user */
$user = $model->getUser();
$btnSubmit = Html::submitButton($user->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-success']);
?>
<div class="user-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="user-form panel panel-default">
            <div class="panel-heading">
                <?= $btnSubmit; ?>
                <a class="btn btn-default" href="<?= Yii::$app->request->referrer; ?>">Отмена</a>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php
                    echo $form->field($user, 'username')->textInput([
                        'maxlength' => true,
                    ]),
                    $form->field($user, 'email')->textInput([
                        'maxlength' => true,
                    ]),
                    $form->field($model, 'password')->passwordInput([
                        'maxlength' => true,
                    ]),
                    $form->field($model, 'passwordConfirm')->passwordInput([
                        'maxlength' => true,
                    ]),
                    $form->field($model, 'selectedRoles')->dropDownList($model->getRolesList(),[
                        'multiple' => true,
                    ]);
                    ?>
                </div>
            </div>
            <div class="panel-footer">
                <?= $btnSubmit; ?>
                <a class="btn btn-default" href="<?= Yii::$app->request->referrer; ?>">Отмена</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
