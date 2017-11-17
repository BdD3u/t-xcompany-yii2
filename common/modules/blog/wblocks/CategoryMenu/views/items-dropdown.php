<?php
$tree =& $res;
$treeList = [];
$breadcrumbs = '';

$formatItemList = function(&$tree, $breadcrumbs) use (&$treeList, &$formatItemList) {
    foreach($tree as $id=>&$cat) {
        $treeList[$id] = $breadcrumbs . $cat['name'];
        if(isset($cat['childs']) && $cat['childs']) {
            $formatItemList($cat['childs'], $treeList[$id] . '/');
        }
    }
};
$formatItemList($tree, $breadcrumbs);

return $treeList;