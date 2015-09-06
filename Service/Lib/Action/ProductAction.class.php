<?php
class ProductAction extends CommonAction {

    public function index(){
        $id = $this->_get('cid');
        $this->assign('crumbs', D('Common')->getCrumbs($id));
        
        $category = D('Category')->where('status=1')->find($id); 
        $this->seo($category['title'], $category['keywords'], $category['description'], D('Common')->getPosition($id));
        
        $types = D('Product')->geProductCategorys();
        $this->assign('types',$types);
        
        $map = D('Common')->getCategoryMap($id);
        $map['status'] = array('eq',1);
        $count = D("Product")->where($map)->count(); 
        $Page = new Page($count,35);
        $list = D('Product')->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page', $Page->show());
        $this->assign('list',$list);
        
        $this->display();
    }

    public function view(){
        $id = $this->_get('id');
        $info = D('Product')->where('status=1')->find($id);
        $this->assign('crumbs', D('Common')->getCrumbs($info['cid'], $info['id']));
        $this->seo($info['title'], $info['keywords'], $info['description'], D('Common')->getPosition($info['cid']));
        if(!strstr($info['url'],'http'))$this->assign('local',true);
        $this->assign('info',$info);
        
        $types = D('Product')->geProductCategorys();
        $this->assign('types', $types);
        
        $this->display();
    }
}