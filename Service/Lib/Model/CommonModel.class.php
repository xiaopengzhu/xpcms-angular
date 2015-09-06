<?php
class CommonModel extends Model {
    
    public function getPosition($id){
        $category = D('Category')->where('status=1')->find($id);
        if($category['pid']==0){
            $position = $id;
        }else{
            $position = $category['pid'];
        }
        return $position;
    }
    
    public function getCrumbs($cid, $tid = false) {
        $crumbs = array();
        $category = D('Category')->where('status=1')->find($cid);
        if ($category['pid'] == 0) {
            $ary = array(
                'title' => $category['title'],
                'url' => $category['module'].'/index/cid/'.$category['id']
            );
            array_push($crumbs, $ary);
        } else {
            $parent = D('Category')->where('status=1')->find($category['pid']);
            $ary = array(
                'title' => $parent['title'],
                'url' => $parent['module'].'/index/cid/'.$parent['id']
            );
            array_push($crumbs, $ary);
            $ary = array(
                'title' => $category['title'],
                'url' => $category['module'].'/index/cid/'.$category['id']
            );
            array_push($crumbs, $ary);
        }
        if ($tid) {
            $module = ucfirst($category['module']);
            $detail = D($module)->find($tid);
            $ary = array(
                'title' => $detail['title'],
            );
            array_push($crumbs, $ary);
        }
        return $crumbs;
    }
    
    public function getCategoryMap($id){
        $category = D('Category')->where('status=1')->find($id);
        if($category['pid']==0){
            $categorys = D('Category')->where('status=1 AND pid='.$category['id'])->select();
            if(is_array($categorys)){
                    foreach($categorys as $val) $ary[]=$val['id'];
            }
            $map['cid']    = array('in',$ary);
        }else{
            $map['cid'] = array('eq',$id);
        }
        return $map;
    }
    
    public function getSubCategorys($id) {
        $category = D('Category')->where('status=1')->find($id);
        if($category['pid']==0){
            $categorys = D('Category')->where('status=1 AND pid='.$category['id'])->select();
        } else {
            $categorys = D('Category')->where('status=1 AND pid='.$category['pid'])->select();
        }
        return $categorys;
    }
}