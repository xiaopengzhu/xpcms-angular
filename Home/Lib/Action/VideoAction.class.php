<?php
class VideoAction extends CommonAction {

    public function index(){
        $id = $this->_get('cid');
        $this->assign('crumbs', D('Common')->getCrumbs($id));
        
        $category = D('Category')->where('status=1')->find($id); 
        $this->seo($category['title'], $category['keywords'], $category['description'], D('Common')->getPosition($id));
        
        $types = D('Category')->where('status=1 AND pid!=0 AND module="Video"')->order('sort DESC')->select();
        $this->assign('types',$types);
        
        $map = D('Common')->getCategoryMap($id);
        $map['status'] = array('eq',1);
        $count = D("Video")->where($map)->count(); 
        $Page = new Page($count,35);
        $list = D('Video')->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page', $Page->show());
        $this->assign('list',$list);
        
        $this->display();
    }

    public function view(){
        $id = $this->_get('id');
        $info = D('Video')->where('status=1')->find($id);
        $this->assign('crumbs', D('Common')->getCrumbs($info['cid'], $info['id']));
        $this->seo($info['title'], $info['keywords'], $info['description'], D('Common')->getPosition($info['cid']));
        if(!strstr($info['url'],'http'))$this->assign('local',true);
        $this->assign('info',$info);
        
        $categorys = D('Category')->where('status=1 AND pid!=0 AND module="Video"')->order('sort DESC')->select();
        $this->assign('types', $categorys);
        
        import("@.ORG.Util.Dir");
        $path = dirname(APP_PATH)."/Public/images/head";
        $dir = new Dir($path);
        $this->assign('heads', $dir->_values);
        $this->display();
    }
    
    public function getCommentList() {
        $id = $this->_get("id");
        $map = array(
            'module' => 'video',
            'aid' => $id,
            'status' => 1,
            'pid' => 0
        );
        $Page = new Page(D('Comment')->where($map)->count(), 8);
        $comment = D('Comment')->relation(true)->where($map)->order('add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        echo json_encode($comment);
        exit;
    }
}