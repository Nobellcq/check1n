<?php

class DefaultController extends Controller
{
    public $list_item;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('rawlist'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'check1n', 'rawlist','checklist'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('result'),
                'users' => array('kaoqin', 'admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index', array('id' => Yii::app()->user->name));
    }

    public function actionChecklist()
    {
        $this->render('checklist', array('id' => Yii::app()->user->name));
    }

    public function actionLogin()
    {

    }

    public function actionCheck1n($userid = "")
    {
        if ($userid != "") {
            $this->render('check1n', array('id' => $userid));
        }
    }

    public function actionRawList($starttime = "")
    {
        if ($starttime == "") {
            $starttime = date("Y-m-d", time() - 3600 * 24 * 6);
        }

        // echo $starttime."<br>";
        $sql = "SELECT USERINFO.Badgenumber, CHECKINOUT.CHECKTIME FROM USERINFO, CHECKINOUT WHERE USERINFO.USERID=CHECKINOUT.USERID AND CHECKTIME > #$starttime# ORDER BY CHECKTIME DESC;";
        $db = new PDO(Yii::app()->params['db_check1n']) or die("Connect Error");
        $result = $db->query($sql)->fetchAll();
//        var_dump($result);

        echo "<table>";
        foreach ($result as $k => $v) {
            echo "<tr><td>" . $v[0] . "</td><td>" . $v[1] . "</td></tr>";
        }
        echo "</table>";
    }

    public function actionResult($delta = 0)
    {
        //确定当前日期，找出所在区间的计算周期作为当前操作的时间
        $weekDay = date('w');
        $wd = ($weekDay + 4) % 7 - $delta * 7;
        $starttime = date('Y-m-d H:i:s', strtotime(date('Y-m-d')) - $wd * 24 * 3600);
        $endtime = date('Y-m-d H:i:s', strtotime(date('Y-m-d')) + (7 - $wd) * 24 * 3600);

        $this->render('result', array('starttime' => $starttime, 'endtime' => $endtime, 'delta' => $delta));
    }


}