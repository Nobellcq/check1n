<?php
/**
 * Created by JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-3-21
 * Time: 下午12:27
 * To change this template use File | Settings | File Templates.
 */

class SogouController extends Controller{
    public $list_item;

    public function __construct($id,$module=null)
    {
        parent::__construct($id, $module);
    }

    public function initListItems($list_items){
        $this->list_item = $list_items;
    }
}