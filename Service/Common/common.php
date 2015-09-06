<?php
function getCategoryName($id){
    if (empty ( $id )) {
        return '顶级分类';
    }
    $Category = D ( "Category" );
    $list = $Category->getField ( 'id,title' );
    $name = $list [$id];
    return $name;
}

function getModuleById($id){
    $Category = D ( "Category" );
    $list = $Category->getField ( 'id,module' );
    $module = $list [$id];
    return $module;
}

function getUserName($id){
    if (empty ( $id )) {
        return '游客';
    }
    $User = D ( "User" );
    $list = $User->getField ( 'id,nickname' );
    $name = $list [$id];
    return $name;
}

function getArticleById($id){
    $record = D('Article')->where('id='.$id)->getField('title');
    return $record;
}

function getCode($id) {
    $code = D('Code')->where('status=1')->find($id);
    return $code['content'];
}