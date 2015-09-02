<?php
class UserAction extends CommonAction {

    public function register(){
        if ($_POST) {
            D('User')->create();
            if (D('User')->save()) {
                $this->success('注册成功！');
            } else {
                $this->error('注册失败');
            }
        } else {
            $this->display();
        }
    }
    
    public function foget(){
        $this->display();
    }
    
    public function index(){
        $this->display();
    }
    
    public function edit(){
        $this->display();
    }
    
    public function login() {
        $this->display();
    }
    
    public function ajaxLogin() {
        
    }
    
    public function logout() {
        $this->display();
    }
}