<?php
class ProductAction extends CommonAction {
    
    public function getListData() {
        $id = $this->_get('cid');
        $this->assign('crumbs', D('Common')->getCrumbs($id));
        
        $categorys = D('Product')->geProductCategorys();
        
        $map = D('Common')->getCategoryMap($id);
        $map['status'] = array('eq',1);
        $count = D("Product")->where($map)->count();
        $Page = new Page($count,35);
        $list = D('Product')->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        
        $data = array(
            'crumbs' => $crumbs,
            'categorys' => $categorys,
            'products' => $list
        );
        
        exit(json_encode($data));
    }
    
    public function getViewData() {
        $id = $this->_get('id');
        $info = D('Product')->where('status=1')->find($id);
        $this->assign('crumbs', D('Common')->getCrumbs($info['cid'], $info['id']));
        $this->seo($info['title'], $info['keywords'], $info['description'], D('Common')->getPosition($info['cid']));
        if(!strstr($info['url'],'http'))$this->assign('local',true);
        $this->assign('info',$info);
        
        $categorys = D('Product')->geProductCategorys();
        
        $data = array(
            'product' => $info,
            'categorys' => $categorys
        );
        
        exit(json_encode($data));
    }

}