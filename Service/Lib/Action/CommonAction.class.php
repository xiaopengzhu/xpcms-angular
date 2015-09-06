<?php
class CommonAction extends Action {
    
    function _initialize(){
        Load('extend');
        import("ORG.Util.Page");
        
        $nav_list = D('Category')->relation(true)->where('pid=0 AND status=1')->order('sort DESC')->select();
        $this->assign('link', D('Link')->where('status=1')->order('sort DESC')->limit(7)->select());
        $this->assign('nav_list', $nav_list);
    }

    public function verify(){
        $type = isset($_GET['type'])?$_GET['type']:'gif';
        import("ORG.Util.Image");
        Image::buildImageVerify(4, 1, $type);
    }

    public function seo($title, $keywords, $description, $positioin){
        $this->assign('title', $title);
        $this->assign('keywords', $keywords);
        $this->assign('description', $description);
        $this->assign('position', $positioin);
    }

    public function download(){
        $filename = $_SERVER[DOCUMENT_ROOT].__ROOT__.'/Public/upload/download/'.$this->_get('filename');
        header("Content-type: application/octet-stream");  
        header("Content-Length: ".filesize($filename));  
        header("Content-Disposition: attachment; filename={$this->_get('filename')}");    
        $fp = fopen($filename, 'rb');  
        fpassthru($fp);  
        fclose($fp); 
    }

    public function _empty(){
        $this->redirect("/");
    }
    
    public function getData() {
        $data = array(
            'categorys' => D('Category')->where('status=1 AND pid=0')->select(),
            'links' => D('Link')->where('status=1')->order('sort DESC')->limit(7)->select()
        );
        exit(json_encode($data));;
    }
}