<?php
class MemberAction extends Action {
    public function login() {
        if ($this->_post['account'] && $this->_post['password'] && $this->_post['verify']) {
            if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！');
            }
            $map = array(
                'account' => $this->_post['account'],
                'password' => md5($this->_post['password'])
            );
            $uinfo = D('Member')->where()->select();
            if ($uinfo) {
                $_SESSION[C('MEMBER_AUTH_KEY')] = $uinfo;
                redirect(__APP__);
            } else {
                $this->error('用户不存在或密码错误!');
            }
        } else {
            $this->display();
        }
    }
    
    public function checklogin() {
    
    }
    
    public function logout() {
        unset($_SESSION[C('USER_AUTH_KEY')]);
        unset($_SESSION);
        session_destroy();
    }
    
    public function forget() {
    }
    
    public function _empty(){
        return false;
    }
}