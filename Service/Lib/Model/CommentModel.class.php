<?php
class CommentModel extends RelationModel {
    protected $_link = array(
        'Reply' => array(
            'mapping_type'  => HAS_MANY,
            'class_name'    => 'Comment',
            'parent_key'    => 'pid',
            'mapping_name'  => 'reply'
        )
    );
    
    protected $_validate = array(
        array('head', 'require', '头像不能为空！'),
        array('nickname', 'require', '昵称不能为空！'),
        array('email', 'email', '邮箱格式不正确！'),
        array('content', 'require', '内容不能为空！'),
    );
}