<?php
/**
 * Created by JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-3-28
 * Time: 下午5:02
 * To change this template use File | Settings | File Templates.
 */

/**
 * ajax apis here
 * Class AjaxController
 */
class AjaxController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
//            array('allow',  // allow all users to perform 'index' and 'view' actions
//                'actions'=>array('showresult'),
//                'users'=>array('*'),
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('userlist', 'checklist', 'check1n','updatecheck1n','deletecheck1n'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('showresult'),
                'users' => array('kaoqin','admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    private function renderJson($data = "操作成功", $success = true, $count = 0)
    {
        $result = new Result();
        if ($success) {
            $result->code = 0;
            $result->data = $data;
            $result->data_count = $count;
        } else {
            $result->code = 1;
            $result->error = $data;
        }
        $this->renderPartial("json", array('result' => $result));
    }

    public function actionTest()
    {
        echo Yii::app()->params['db_check1n'];
    }

    public function actionUserList($limit = 20, $page = 1, $q = "")
    {
        if (Yii::app()->user->name == "admin") {
           if($q=="admin"){
               $q = "";
           }
        } else {
            $q = Yii::app()->user->name;
        }
        $db = new PDO(Yii::app()->params['db_check1n']) or die("Connect Error");
        if (is_numeric($page) && is_numeric($limit)) {
            if ($q == "") {
                if ($page == 1) {
                    $sql = 'SELECT TOP ' . $limit . '  USERINFO.USERID AS id, USERINFO.Badgenumber AS nid, USERINFO.Name AS name FROM USERINFO;';
                } else if ($page > 1 && $limit > 0) {
                    $prepages = ($page - 1) * $limit;
                    $sql = 'SELECT TOP ' . $limit . '  USERINFO.USERID AS id, USERINFO.Badgenumber AS nid, USERINFO.Name AS name FROM USERINFO WHERE USERINFO.USERID >
                  (SELECT TOP 1 MAX(USERID) FROM
                  (SELECT TOP ' . $prepages . ' USERINFO.USERID FROM USERINFO ORDER BY USERINFO.USERID));';

                }

                $cnt_sql = "SELECT COUNT(USERID) AS count FROM USERINFO";
                $count = $db->query($cnt_sql)->fetchColumn();
            } else {
                $sql = "SELECT USERINFO.USERID AS id, USERINFO.Badgenumber AS nid, USERINFO.Name AS name FROM USERINFO WHERE Badgenumber='" . $q . "';";
                $count = 1;
            }

            $data = $db->query($sql)->fetchAll();


            foreach ($data as $k => $v) {
                $name = iconv('gbk', 'utf-8', trim($v['name']));

                $len = strlen($name);

                if ($len == 14) {
                    $name = substr($name, 0, 9);
                } else if ($len == 10) {
                    $name = substr($name, 0, 6);
                }

                $data[$k]['name'] = $name;
            }
            $_SESSION['userid'] = $data[0]['id'];
            //var_dump($data);
            $this->renderJson($data, true, $count);
        }
    }

    public function actionCheckList($userid = "", $limit = 20, $page = 1)
    {
        if (Yii::app()->user->name !== "admin") {
            if (!isset($_SESSION['userid'])) {
                return;
            }
            $userid = $_SESSION['userid'];
        }

        if ($userid == "") {
            $data = "";
            $this->renderJson($data, true, 0);
        } else {
            $db = new PDO(Yii::app()->params['db_check1n']) or die("Connect Error");
            if (is_numeric($page) || is_numeric($limit)) {
                if ($page == 1) {
                    $sql = 'SELECT TOP ' . $limit . '  USERID AS id,CHECKINOUT.CHECKTIME AS checktime FROM CHECKINOUT WHERE USERID=' . $userid . ' ORDER BY CHECKTIME DESC;';
                } else if ($page > 1 && $limit > 0) {
                    $prepages = ($page - 1) * $limit;

                    $sql = 'SELECT TOP ' . $limit . '  USERID AS id,CHECKINOUT.CHECKTIME AS checktime FROM CHECKINOUT WHERE USERID=' . $userid . ' AND CHECKTIME<
                  (SELECT TOP 1 MIN(CHECKTIME) FROM
                  (SELECT TOP ' . $prepages . ' CHECKTIME FROM CHECKINOUT WHERE USERID=' . $userid . ' ORDER BY CHECKTIME DESC)) ORDER BY CHECKTIME DESC;';

                }
                $data = $db->query($sql)->fetchAll();
                $cnt_sql = "SELECT COUNT(USERID) AS count FROM CHECKINOUT WHERE USERID=" . $userid;
                $count = $db->query($cnt_sql)->fetchColumn();

                $this->renderJson($data, true, $count);
            }

        }
    }

    public function actionCheck1n()
    {
        $userid = "";
        if (Yii::app()->user->name == "admin") {
            $userid = $_POST['userid'];
        } else {
            $userid = $_SESSION['userid'];
        }

        $db = new PDO(Yii::app()->params['db_check1n']) or die("Connect Error");
        $result = 0;
        for ($i = 0; $i < Yii::app()->params['check1n_count']; $i++) {
            if(isset($_POST[$i])){
                $checktime = $_POST[$i];
                if ($checktime != null && $userid != null) {
                    $sql = "INSERT INTO CHECKINOUT(USERID,CHECKTIME,CHECKTYPE,SENSORID,sn, UserExtFmt) values($userid,'$checktime','I',1,02711431407,1);";
                    $result += $db->exec($sql);

                    $this->sqlLog($sql);
                }
            }
        }

        if ($result > 0) {
            //succ
            $this->renderJson("成功插入 $result 条记录");
        } else {
            $this->renderJson("操作失败", false);
        }

    }

    public function actionUpdateCheck1n()
    {
        $userid = "";
        if (Yii::app()->user->name == "admin") {
            $userid = $_POST['userid'];
        } else {
            $userid = $_SESSION['userid'];
        }
        $checktime = $_POST['newtime'];
        $oldCheckTime = $_POST['oldtime'];

        $sql = "UPDATE CHECKINOUT SET CHECKTIME='$checktime' WHERE CHECKTIME=#$oldCheckTime# AND USERID=$userid;";
        $db = new PDO(Yii::app()->params['db_check1n']) or die("Connect Error");

        if ($checktime != null && $userid != null) {
            $result = $db->exec($sql);
            if ($result > 0) {
                //succ
                $this->renderJson("成功更新 $result 条记录");
                $this->sqlLog($sql);
            } else {
                $this->renderJson("操作失败", false);
            }
        }
    }

    public function actionDeleteCheck1n(){
        $userid = "";
        if (Yii::app()->user->name == "admin") {
            $userid = $_POST['userid'];
        } else {
            $userid = $_SESSION['userid'];
        }
        $oldCheckTime = $_POST['oldtime'];

        $sql = "DELETE FROM CHECKINOUT WHERE CHECKTIME=#$oldCheckTime# AND USERID=$userid;";

        $db = new PDO(Yii::app()->params['db_check1n']) or die("Connect Error");

        if ($oldCheckTime != null && $userid != null) {
            $result = $db->exec($sql);
            if ($result > 0) {
                //succ
                $this->renderJson("成功删除 $result 条记录");
                $this->sqlLog($sql);
            } else {
                $this->renderJson("操作失败", false);
            }
        }
    }

    private function sqlLog($sqlToLog){
        try{
            $userid = Yii::app()->user->name;
            $db = new PDO("mysql:host=10.103.26.159;dbname=check1n",'enbandari','ss1013');
            $sql = "insert into oplog (userid,sqllog) values('$userid', '".addslashes($sqlToLog)."')";
            $db->exec($sql);
        }catch(PDOException $e){
            //echo $e->errorInfo();
            echo iconv('gbk', 'utf-8', trim($e->getMessage()));
        }
    }

    public function actionShowResult(){
        $starttime = $_POST['starttime'];
        //$starttime = '2014-04-07 00:00:00';
        $endtime = $_POST['endtime'];


        if($starttime == ""){
            $starttime = date("Y-m-d",time() - 3600 * 24 * 6);
        }

        // echo $starttime."<br>";
        $sql = "SELECT USERINFO.Badgenumber, CHECKINOUT.CHECKTIME FROM USERINFO, CHECKINOUT WHERE USERINFO.USERID=CHECKINOUT.USERID AND CHECKTIME > #$starttime# ORDER BY CHECKTIME DESC;";
        $db = new PDO(Yii::app()->params['db_check1n']) or die("Connect Error");
        $result = $db->query($sql)->fetchAll();

        $tempPath = 'temp.txt';
        $output = 'out.html';
        $content = '';
        foreach($result as $k=>$v){
            //echo "<tr><td>".$v[0]."</td><td>".$v[1]."</td></tr>";
            $content = $content.$v[0].' '.$v[1]."\n";
        }
        $dir = Yii::app()->basePath.'/../py/';
        FileUtils::saveFile($dir.$tempPath,$content);
        //    passthru('python check1n/py/kaoqin.py check1n/py/abc.txt check1n/py/out.html 05 05 05 05 05 07 08 09 12 13');
        $time3 = preg_split("/[-:\\s]/i",$starttime);//wed
        $time = array($time3);
        $i = 1;
        while($i <7){
            array_push($time,preg_split("/[-:\\s]/i",date('Y-m-d H:i:s',(strtotime($starttime) +$i * 24 * 3600))));
            $i++;
            if($i == 3){
                $i = 5;
            }
        }

        CallPython::callThrough($dir.'kaoqin.py',array( $dir.$tempPath,$dir.$output,$time[0][1],$time[1][1],$time[2][1],$time[3][1],$time[4][1],$time[0][2],$time[1][2],$time[2][2],$time[3][2],$time[4][2],));

        //echo '({"location":"py/'.$output.'"})';
        $this->renderJson('py/'.$output);
    }
}