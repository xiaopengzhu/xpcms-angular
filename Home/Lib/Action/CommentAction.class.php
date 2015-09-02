<?php
class CommentAction extends CommonAction {
    
    public function index(){
        $map = array(
            'tid' => 0,
            'status' => 1,
            'pid' => 0
        );
        $Page = new Page(D('Comment')->where($map)->count(), 10);
        $comment = D('Comment')->relation(true)->where($map)->order('add_time DESC')->limit($Page->firstRow.', '.$Page->listRows)->select();
        $this->assign('page', $Page->show());
        
        $this->assign('comm_list', $comment);
        $this->assign('position', 0);
        $this->assign('title', '留言列表');
        import("@.ORG.Util.Dir");
        $path = dirname(APP_PATH)."/Public/images/head";
        $dir = new Dir($path);
        $this->assign('heads', $dir->_values);
        $this->display();
    }
}