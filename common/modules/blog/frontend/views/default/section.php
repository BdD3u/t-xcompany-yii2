<?php
/**
 * @var \common\modules\blog\models\BlogArticle[] $articles
 * @var \yii\data\Pagination $pagination
 * @var \common\modules\blog\models\BlogCategory $category
 */

//use common\modules\blog\frontend\assets\MainAsset;
//
//MainAsset::register($this);
if ($articles): ?>
    <div class="list-articles">

        <div class="row">
            <?php foreach ($articles as $article):
                $link = \yii\helpers\Url::to(['/blog/default/article', 'id' => $article->id]);
                $title = \yii\helpers\StringHelper::truncate($article->title, 90, '...');
                $prevContent = \yii\helpers\StringHelper::truncate(strip_tags($article->preview_content), 150, '...');
                //var_dump($article->image->getWebPath());
                ?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail article-thumbnail">
                        <a class="article-image" style="background-image: url('<?= $article->image->getWebPath(); ?>'"
                           href="<?= $link; ?>"></a>
                        <div class="caption">
                            <h4 class="article-header"><a href="<?= $link; ?>"><?= $title ?></a></h4>
                            <p class="article-prev-content"><?= $prevContent; ?></p>
                            <p>
                                <a href="<?= $link; ?>" class="btn btn-primary" role="button">Читать!</a>
                            </p>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>

        </div>
    </div>
    <?= \yii\widgets\LinkPager::widget(compact('pagination')); ?>
<? endif; ?>


