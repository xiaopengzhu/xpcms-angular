<?php
class CategoryModel extends RelationModel {
    protected $_link = array(
        'Subcates' => array(
            'mapping_type'  => HAS_MANY,
            'class_name'    => 'Category',
            'parent_key'    => 'pid',
            'condition'     => 'status = 1',
            'mapping_name'  => 'sub_nav'
        )
    );
}