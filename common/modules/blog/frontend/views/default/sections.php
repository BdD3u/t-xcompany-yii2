<?php
$getViewSection = function ($blogMap) use (&$getViewSection) {
    ?>
    <ul>
        <?php foreach ($blogMap as $item):
            $link = isset($item['url']) ? \yii\helpers\Url::to($item['url']) : 'javascript: void(0);';
            ?>
            <li>
                <a href="<?= $link; ?>"><?= $item['label']; ?></a>
                <?php if(isset($item['items']) && is_array($item['items']) && $item['items']):
                    $getViewSection($item['items']);
                endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
};
?>
<? if(isset($blogMap) && $blogMap):
$getViewSection($blogMap);
endif; ?>
