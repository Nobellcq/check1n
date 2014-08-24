<?php
/**
 * Created by JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-3-28
 * Time: 下午4:32
 * To change this template use File | Settings | File Templates.
 */

class Result {
    /**
     * 0--success
     * 1--error,check error for details.
     */
    public $code;
    public $error;
    public $data;
    public $data_count;
}