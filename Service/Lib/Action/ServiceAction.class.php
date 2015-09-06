<?php
class ServiceAction extends CommonAction {

    public function getCategorys() {
        $data = D('Category')->where('status=1 AND pid=0')->select();
        exit(json_encode($data));
    }
    
    public function getIndexData() {
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
    
    public function getLink() {
        $data = D('Link')->where('status=1')->order('sort DESC')->limit(7)->select();
        exit(json_encode($data));
    }
    
    public function getArtList() {
        $id = $_GET['id'];
        $data = D('Article')->where('status=1 AND cid='.$id)->order('sort DESC')->limit(7)->select();
        exit(json_encode($data));
    }
    
}