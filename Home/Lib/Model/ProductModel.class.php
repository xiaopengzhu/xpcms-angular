<?php
class ProductModel extends CommonModel {
    
    public function geProductCategorys() {
        $categorys = D('Category')->where('status=1 AND pid=0 AND module="Product"')->select();
        if(is_array($categorys)) {
            foreach ($categorys as $key => $val) {
                $categorys[$key]['sub'] = D('Category')->where('status=1 AND pid='.$val['id'].' AND module="Product"')->select();
            }
        }
        return $categorys;
    }
}