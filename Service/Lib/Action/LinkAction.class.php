<?php
class LinkAction extends CommonAction {

    public function index(){
        $this->assign('list',D('Link')->where('status=1')->order('sort DESC')->select());
        $this->seo('友情链接列表', C('SITE_KEYWORDS'), C('SITE_DESCRIPTION'), 0);
        $this->display();
    }
    
    public function add(){
        if($_SESSION['verify'] != md5($_POST['verify'])) {
            $data = array(
                'code' => 1,
                'msg' => '验证码错误',
                'data' => ''
            );
            exit(json_encode($data));
        }
        if (!D("Link")->create()) {
            $data = array(
                'code' => 2,
                'msg' => D("Link")->getError(),
                'data' => ''
            );
            exit(json_encode($data));
        } else {
            if(D("Link")->add()) {
                $data = array(
                    'code' => 0,
                    'msg' => "添加成功",
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