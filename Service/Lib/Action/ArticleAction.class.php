<?php
class ArticleAction extends CommonAction{

    public function index(){
        $id = $this->_get('cid');
        
        $categorys = D('Common')->getSubCategorys($id);
        $this->assign('crumbs', D('Common')->getCrumbs($id));
        
        $map = D('Common')->getCategoryMap($id);
        $map['status'] = array('eq',1);
        
        $Page = new Page(D("Article")->where($map)->count(), 8);
        $list = D("Article")->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('list', $list);
        $this->assign('page', $Page->show());
        $this->assign('categorys', $categorys);
        $this->seo($type['title'], $type['keywords'], $type['description'], D('Common')->getPosition($id));
        $this->display();
    }
    
    public function getListData() {
        $id = $this->_get('cid');
        
        $categorys = D('Common')->getSubCategorys($id);
        $crumbs = D('Common')->getCrumbs($id);
        
        $map = D('Common')->getCategoryMap($id);
        $map['status'] = array('eq',1);
        
        $Page = new Page(D("Article")->where($map)->count(), 8);
        $list = D("Article")->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        
        $data = array(
            'crumbs' => $crumbs,
            'arts' => $list,
            'categorys' => $categorys
        );
        
        exit(json_encode($data));
    }

    public function getViewData() {
        $id = $this->_get('id');
        D('Article')->where("id=".$id)->setInc('apv',1);
        
        $info = D('Article')->where("id=$id AND status=1")->find();
        $crumbs = D('Common')->getCrumbs($info['cid'], $info['id']);
        $this->seo($info['title'], $info['keywords'], $info['description'], D('Common')->getPosition($info['cid']));
        
        $art_pre = D('Article')->where("id<$id AND status=1")->order('id DESC')->field('id,title,apv')->find();
        $art_next = D('Article')->where("id>$id AND status=1")->order('id')->field('id,title,apv')->find();
        $art_relate = D('Article')->where("cid=".$info['cid'])->order('id DESC')->limit(5)->field('id,title')->select();
        $map = array(
                'module' => 'article',
                'aid' => $id,
                'status' => 1,
                'pid' => 0
        );
        $Page = new Page(D('Comment')->where($map)->count(), 8);
        $comment = D('Comment')->relation(true)->where($map)->order('add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page', $Page->show());
        $this->assign('comm_list', $comment);
        
        import("@.ORG.Util.Dir");
        $path = dirname(APP_PATH)."/Public/images/head";
        $dir = new Dir($path);
        $this->assign('heads', $dir->_values);
        
        $data = array(
            'art' => $info,
            'crumbs' => $crumbs,
            'art_pre' => $art_pre,
            'art_next' => $art_next,
            'art_relate' => $art_relate
        );
        
        exit(json_encode($data));
    }

    public function view(){
        $id = $this->_get('id');
        D('Article')->where("id=".$id)->setInc('apv',1);
        
        $info = D('Article')->where("id=$id AND status=1")->find();
        $this->assign('info', $info);
        $this->assign('crumbs', D('Common')->getCrumbs($info['cid'], $info['id']));
        $this->seo($info['title'], $info['keywords'], $info['description'], D('Common')->getPosition($info['cid']));
        
        $art_pre = D('Article')->where("id<$id AND status=1")->order('id DESC')->field('id,title,apv')->find();
        $this->assign('art_pre', $art_pre);
        
        $art_next = D('Article')->where("id>$id AND status=1")->order('id')->field('id,title,apv')->find();
        $this->assign('art_next', $art_next);
        
        $art_relate = D('Article')->where("cid=".$info['cid'])->order('id DESC')->limit(5)->field('id,title')->select();
        $this->assign('art_relate', $art_relate); 
        
        $map = array(
            'module' => 'article',
            'aid' => $id,
            'status' => 1,
            'pid' => 0
        );
        $Page = new Page(D('Comment')->where($map)->count(), 8);
        $comment = D('Comment')->relation(true)->where($map)->order('add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page', $Page->show());
        $this->assign('comm_list', $comment);
        
        import("@.ORG.Util.Dir");
        $path = dirname(APP_PATH)."/Public/images/head";
        $dir = new Dir($path);
        $this->assign('heads', $dir->_values); 
        $this->display();
    }

    public function addComment(){
        if($_SESSION['verify'] != md5($_POST['verify'])) {
            $data = array(
                'code' => 1,
                'msg' => '验证码错误',
                'data' => ''
            );
            exit(json_encode($data));
        }
        if (!D("Comment")->create()) {
            $data = array(
                'code' => 2,
                'msg' => D("Comment")->getError(),
                'data' => ''
            );
            exit(json_encode($data));
        } else {
            D("Comment")->add_time = time();
            D("Comment")->ip = get_client_ip();
            if(D("Comment")->add()) {
                $data = array(
                    'code' => 0,
                    'msg' => "添加成功，请等待审核",
                    'data' => ''
                );
                exit(json_encode($data));
            } else {
                $data = array(
                    'code' => 500,
                    'msg' => '服务器内部错误',
                    'data' => ''
                );
                exit(json_encode($data));
            }
        }
    }
}