<?php
class LinkModel extends CommonModel {
    protected $_validate = array(
        array('title', 'require', '名称不能为空！'),
        array('url', 'url', '链接格式不正正确！'),
        array('intro', 'require', '简介不能为空！'),
    );
}