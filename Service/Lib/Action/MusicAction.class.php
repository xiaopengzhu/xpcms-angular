<?php
class MusicAction extends CommonAction {
    
    public function index(){
        $id = $this->_get('cid');
        $this->assign('crumbs', D('Common')->getCrumbs($id));
        $category = D('Category')->where('status=1')->find($id);
        $this->seo($category['title'], $category['keywords'], $category['description'], D('Common')->getPosition($id));
        
        $categorys = D('Category')->where('status=1 AND pid!=0 AND module="Music"')->order('sort DESC')->select();
        $this->assign('categorys', $categorys);
        
        $map = D('Common')->getCategoryMap($id);
        $list = D('Music')->where($map)->order('sort DESC')->select();
        foreach ($list as $key => $val){
            if(!strstr($val['url'],'http')) $list[$key]['url']='./Public/upload/music/'.$val['url'];
        }
        $this->assign('list', $list);
        
        $this->display();
    }
    
    public function getLyrics($id){
        $lyrics = D("Music")->where("id=".$id)->getField("lyrics");
        if (strlen($lyrics) < 10) return false;
        $ary = explode("\n", $lyrics);
        foreach ($ary as $k => $v) {
            preg_match('/^\[(.*)\]/', $v, $matches );
            $timestr = $matches[0];
            preg_match_all('/\[(.*)\]/U', $timestr, $times);
            foreach ($times[1] as $v2) {
                $split = preg_split('/^\[(.*)\]/', $v);
                $text = $split[1];
                $keyary = explode(".", $v2);
                $key = strtotime("00:".$keyary[0]);
                $data[$key]['time'] = $keyary[0];
                $data[$key]['value'] = $text;
            }
        }
        ksort($data);
        exit(json_encode($data));
    }
    
    public function getData() {
        $id = $this->_get('cid');
        $crumbs = D('Common')->getCrumbs($id);
        
        $categorys = D('Category')->where('status=1 AND pid!=0 AND module="Music"')->order('sort DESC')->select();
        
        $map = D('Common')->getCategoryMap($id);
        $list = D('Music')->where($map)->order('sort DESC')->select();
        foreach ($list as $key => $val){
            if(!strstr($val['url'],'http')) $list[$key]['url']='./Public/upload/music/'.$val['url'];
        }
        
        $data = array(
            'crumbs' => $crumbs,
            'categorys' => $categorys,
            'musics' => $list
        );
        exit(json_encode($data));
    }
}