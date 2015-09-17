<?php
class VideoAction extends Action {
    
    public function getListData() {
        $id = $this->_get('cid');
        $crumbs = D('Common')->getCrumbs($id);
        
        $categorys = D('Category')->where('status=1 AND pid!=0 AND module="Video"')->order('sort DESC')->select();
        
        $map = D('Common')->getCategoryMap($id);
        $map['status'] = array('eq',1);
        $count = D("Video")->where($map)->count();
        $Page = new Page($count,35);
        $list = D('Video')->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page', $Page->show());
        $this->assign('list',$list);
        
        $data = array(
            'crumbs' => $crumbs,
            'categorys' => $categorys,
            'videos' => $list
        );
        exit(json_encode($data));
    }
    
    public function getViewData() {
        $id = $this->_get('id');
        $info = D('Video')->where('status=1')->find($id);
        $crumbs = D('Common')->getCrumbs($info['cid'], $info['id']);
        if(!strstr($info['url'],'http'))$this->assign('local',true);
        
        $categorys = D('Category')->where('status=1 AND pid!=0 AND module="Video"')->order('sort DESC')->select();
        $this->assign('types', $categorys);
        
        import("@.ORG.Util.Dir");
        $path = dirname(APP_PATH)."/Public/images/head";
        $dir = new Dir($path);
        $this->assign('heads', $dir->_values);
        
        $data = array(
            'crumbs' => $crumbs,
            'video' => $info,
            'categorys' => $categorys
        );
        exit(json_encode($data));
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