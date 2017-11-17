<?php
/**
 * @var \yii\web\View $this
 * @var \common\modules\blog\models\BlogArticle $article
 */
?>
<div class="row-fluid blog-article-content">
    <div class="article-image" style="background-image: url('<?= $article->image->getWebPath(); ?>');">
        <div class="wr-article-header">
            <div class="article-date">
                <?= Yii::$app->formatter->asDate(strtotime($article->created_at)); ?>
            </div>
            <h1><?= $article->title; ?></h1>
        </div>
    </div>
    <div class="article-content">
        <?= $article->content; ?>
    </div>
</div>