<?php
class PhotoAction extends Action {
    
    public function getData() {
        $id = $this->_get('cid');
        $crumbs = D('Common')->getCrumbs($id);
        
        $categorys = D('Category')->where('status=1 AND pid!=0 AND module="Photo"')->order('sort DESC')->select();
        $this->assign('categorys', $categorys);
        
        $map = D('Common')->getCategoryMap($id);
        $map['status'] = array('eq',1);
        $count = D("Photo")->where($map)->count();
        $Page = new Page($count,24);
        $list = D("Photo")->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page', $Page->show());
        
        $data = array(
            'crumbs' => $crumbs,
            'categorys' => $categorys,
            'photos' => $list
        );
        exit(json_encode($data));
    }
}