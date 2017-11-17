<?php
namespace common\modules\blog\wblocks\CategoryMenu;


use common\modules\common\WBlockAbstract;
use common\modules\blog\models\BlogCategory;

class Block extends WBlockAbstract
{
    protected $categories;
    protected $tree;

    protected function init() {
        $this->tree = [];
        $this->setCategories();
        $this->buildTree();
        $this->res =& $this->tree;
    }

    protected static function getBaseDir(): string
    {
        return __DIR__;
    }

    protected function buildTree()
    {
        $cats =& $this->categories;
        $tree =& $this->tree;

        foreach($cats as $id=>&$cat) {
            if($cat['parent_id'] === null) {
                // set root nodes
                $tree[$id] =& $cat;
            } elseif(isset($cats[$cat['parent_id']])) {
                // set childs
                if(!isset($cats[$cat['parent_id']]['childs'])) {
                    $cats[$cat['parent_id']]['childs'] = [];
                }
                $cats[$cat['parent_id']]['childs'][$cat['id']] =& $cat;
            }
        }
    }

    protected function setCategories()
    {
        $this->categories = BlogCategory::find()
            ->select('*')
            ->indexBy('id')
            ->orderBy(['parent_id' => SORT_ASC])
            ->asArray()
            ->all();
    }
}