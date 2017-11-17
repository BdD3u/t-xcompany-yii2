<?php
/**
 * @todo Делалось ради эксперемента, переделать без предварительного создания дерева.
 */
$rKey = 0;
while(($section = current($res))) {
    $r[$rKey] = ['label' => $section['name'], 'url' => ['/blog/default/section', 'id'=>$section['id']], 'items' => []];

    $curr =& $section;
    $currItems =& $r[$rKey]['items'];
    ++$rKey;
    $prev = [];
    $prevItems = [];
    $prevLastId = 0;

    if(!isset($curr['childs'])) {
        $curr['childs'] = [];
    }

    while(($ch = current($curr['childs']))) {
        $next = true;
        $currItems[] = ['label' => $ch['name'], 'url' => ['/blog/default/section', 'id'=>$ch['id']], 'items' => []];
        if(isset($ch['childs']) && $ch['childs']) {
            $prev[++$prevLastId] =& $curr;
            $prevItems[$prevLastId] =& $currItems;
            $curr = $ch;
            //$curr =& $ch;
            $currItems =& $currItems[count($currItems) - 1]['items'];
            $next = false;
            continue;
        }

        $test = $next && isset($curr['childs']) && next($curr['childs']);
        if($next && !$test && $prev) {
            $curr =& $prev[$prevLastId];
            $currItems =& $prevItems[$prevLastId];
            unset($prev[$prevLastId]);
            unset($prevItems[$prevLastId]);
        }
    }
    next($res);
}

return $r;