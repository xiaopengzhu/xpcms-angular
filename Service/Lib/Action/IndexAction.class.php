<?php
class IndexAction extends CommonAction{

    public function index(){
        $this->assign('diary',D('Diary')->where('status=1')->order('add_time DESC')->limit(8)->select());
        $this->assign('top_art', D('Article')->where('status=1')->order('sort DESC')->limit(3)->select());
        $this->assign('slide', D('Photo')->where('status=1 AND cid=5')->select());
        $this->assign('hot_art', D('Article')->where('status=1')->order('apv DESC')->limit(7)->select());
        $this->assign('new_art', D('Article')->where('status=1')->order('add_time DESC')->limit(7)->select());
        $this->assign('new_leave', D('Comment')->where('status=1 AND pid=0 AND type=0')->order('add_time DESC')->limit(7)->select());
        $this->assign('new_comment', D('Comment')->where('status=1 AND pid=0 AND type!=0')->order('add_time DESC')->limit(7)->select());
        $this->seo(C('SITE_NAME'), C('SITE_KEYWORDS'), C('SITE_DESCRIPTION'), 0);
        $this->display();
    }

    public function diary(){
        $count = D("Diary")->count(); 
        $Page = new Page($count,12);
        $list = D("Diary")->order('add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $Page->show());
        $this->seo('站长日记', C('SITE_KEYWORDS'), C('SITE_DESCRIPTION'), 0);
        $this->display();
    }

    public function search(){
        $data = $this->_post['words'];
        $map = "status=1 AND title LIKE '%$data%' OR content LIKE '%$data%'";
        $count = D("Article")->where($map)->count();
        $Page = new Page($count,8);
        $r = D("Article")->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        
        foreach($r as $val){
            $val['title']=str_replace($data,"<font color=red><b>$data</b></font>",$val['title']);
            $val['content']=str_replace($data,"<font color=red><b>$data</b></font>",$val['content']);
            $list[]=$val;
        }
        $this->assign('list', $list);
        $this->assign('page', $Page->show());
        $this->seo('搜索'.$data.'结果', C('SITE_KEYWORDS'), C('SITE_DESCRIPTION'), 0);
        $this->display();
    }
    
    public function getData() {
        $data = array(
            'diary' => D('Diary')->where('status=1')->order('add_time DESC')->limit(8)->select(),
            'top_art' => D('Article')->where('status=1')->order('sort DESC')->limit(3)->select(),
            'slide' => D('Photo')->where('status=1 AND cid=5')->select(),
            'hot_art' => D('Article')->where('status=1')->order('apv DESC')->limit(7)->select(),
            'new_art' => D('Article')->where('status=1')->order('add_time DESC')->limit(7)->select(),
            'new_leave' => D('Comment')->where('status=1 AND pid=0 AND type=0')->order('add_time DESC')->limit(7)->select(),
            'new_comment' => D('Comment')->where('status=1 AND pid=0 AND type!=0')->order('add_time DESC')->limit(7)->select()
        );
        exit(json_encode($data));
    }
}