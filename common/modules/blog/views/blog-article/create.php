<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

mihaildev\elfinder\Assets::noConflict($this);


/* @var $this yii\web\View */
/** @var \common\modules\blog\models\BlogArticleAdminForm $fBlogArticle */
/** @var \common\modules\blog\models\BlogArticle $article */
$article = $fBlogArticle->getArticle();
$btnSubmit = Html::submitButton($article->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-success']);
?>
<div class="blog-article-create">
    <?php $form = ActiveForm::begin(); ?>
    <div class="user-form panel panel-default">
        <div class="panel-heading">
            <?= $btnSubmit; ?>
            <a class="btn btn-default" href="<?= Yii::$app->request->referrer; ?>">Отмена</a>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <?php
                echo $form->field($article, 'title')->textInput(['maxlength' => true]),
                $form->field($article, 'code')->textInput(['maxlength' => true]),
                $form->field($article, 'active')->dropDownList([0 => 'Нет', 1 => 'Да']),
                $form->field($article, 'blog_category_id')->dropDownList($fBlogArticle->getListCategories()),
                $form->field($article, 'preview_content')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [])
                ]),//->textarea(['rows' => 6]),
                $form->field($article, 'content')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [])
                ]),//->textarea(['rows' => 20]),
                $form->field($fBlogArticle->getImageUploader(), 'imageFiles[]')->fileInput(['multiple' => false, 'accept' => 'image/*']);

                if (!$article->isNewRecord && $article->image_id && $article->image->getWebPath()):
                    ?>

                    <div class="row">
                        <div class="col-xs-6 col-md-1">
                            <?php
                            //if (!$article->isNewRecord && $article->image_id) {
                            echo Html::img($article->image->getWebPath(), ['width' => '100%', 'class' => 'thumbnail']);
                            //}
                            ?>
                        </div>
                        <p class="clearfix"></p>
                    </div>
                    <?php
                endif;

                echo $form->field($fBlogArticle, 'selectedTags')->dropDownList($fBlogArticle->getListTags(), ['multiple' => true,]),
                $form->field($article, 'seo_keywords')->textInput(['maxlength' => true]),
                $form->field($article, 'seo_description')->textInput(['maxlenth' => true]);

                //var_dump($article);
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