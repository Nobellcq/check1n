<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo CHtml::encode($this->pageTitle);
        ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>

    <script src="js/sogou_tabs.js"></script>
    <script src="js/sogou_dialog.js"></script>


    <style>
        .head {
            position: fixed;
            left: 10;
            top: 0
        }

        #dialog label, #dialog input {
            display: block;
        }

        #dialog label {
            margin-top: 0.5em;
        }

        #dialog input, #dialog textarea {
            width: 95%;
        }

        #tabs {
            margin-top: 1em;
        }

        #tabs li .ui-icon-close {
            float: left;
            margin: 0.4em 0.2em 0 0;
            cursor: pointer;
        }

        #add_tab {
            cursor: pointer;
        }
    </style>

    <?php
    Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
    Yii::app()->getClientScript()->registerCoreScript('yiiactiveform');
    Yii::app()->clientScript->registerCssFile(
        Yii::app()->clientScript->getCoreScriptUrl() .
        '/jui/css/base/jquery-ui.css'
    );
    ?>

    <?php Yii::app()->bootstrap->register(); ?>

</head>

<body>

<?php
//This is the top navigation bar.
$this->widget('bootstrap.widgets.TbNavbar', array(
    'htmlOptions' => array('id' => 'sogou_nav_bar', 'class' => 'head'),
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('id' => 'sogou_nav_menu'),
            'items' => array(

                array('label' => '首页', 'url' => array('/site/index')),
//                array('label' => 'Contact', 'url' => array('/site/contact')),
                array('label' => '结果',
                    'class' => 'bootstrap.widgets.TbMenu',
                    'items' => array(
                        array('label' => '原始结果', 'url' => array('/check1nm/default/rawlist')),
                        array('label' => '最终结果', 'url' => array('/check1nm/default/result')),
                    ),
                    'visible' => !Yii::app()->user->isGuest&&(Yii::app()->user->name == 'kaoqin'||Yii::app()->user->name == 'admin')),
                array('label' => '查询', 'url' => array('/check1nm/default/index'),'visible'=>!Yii::app()->user->isGuest&&Yii::app()->user->name != 'kaoqin' ),
//                array('label' => 'NewsClue', 'url' => array('/NewsClue/default/index')),
//                array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
//                array(
//                    'label'=>'Check1n',
//                    'class' => 'bootstrap.widgets.TbMenu',
//                    'htmlOptions' => array('class' => 'pull-right'),
//                    'items' => array(
//                        array('label' => 'Users', 'url' => array('/check1nm/default/index')),
//                        array('label' => 'Check1ns', 'url' => array('/check1nm/default/index')),
//                        array('label' => 'Check1nNow', 'url' => array('/check1nm/default/check1n')),
//                    ),
//                ),
            ),
        ),
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right'),
            'items' => array(
                array('label' => Yii::app()->user->name, 'url' => '#',
                    'items' => array(
//                        array('label' => 'Login', 'url' => 'javascript:void(0);', 'linkOptions' => array('onclick' => 'createUser()'), 'visible' => Yii::app()->user->isGuest),
//                        array('label' => 'Register', 'url' => 'javascript:createUser();', 'htmlOptions' => array('class' => 'pull-right'), 'visible' => Yii::app()->user->isGuest),
//                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'htmlOptions' => array('class' => 'pull-right'), 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        //    array('label' => 'Register', 'url' => '',  'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                    )),
            ),
        ),
    ),
)); ?>

<div class="container" id="page">
    <div class="row-fluid">
        <?php
        //check if there is any list item to be listed. if not, do nothing.
        if ($this->list_item != null) {
            echo "<div id='nav_body' class='span2'>";
            echo "<ul id='left_nav'style='float:left' class='nav nav-tabs nav-stacked'width='99%'>";
            $size = 0;
            foreach ($this->list_item as $k => $v) {
                echo "<li><a class='list_item' href='javascript:void(0)' targeturl='" . $v['url'] . "'>" . $v['title'] . "</a></li>";
                $size++;
            }
            $height = $size * 10;
            if ($height < 30) {
                $height = 30;
            }
            echo "</ul>";
//            echo "<button id='toggle_left' width='1%' style='position:relative;float:left;height:" . $height . "px;width:20px;padding:0' class='btn pull-right'><i id='toggle_icon' class='icon-chevron-left'></i></button>";
            echo "</div>";

            echo "<div id='tabs_body' style='float:left;margin-left: 1px' class='span10'><div id='tabs'style='margin-top: 0px'></i><ul><div class='btn-group'style='float:left'></div></ul></div>";

        }
        ?>

        <?php
        //This is the main body of the page.
        echo $content;
        ?>
    </div>
</div>
<div class="clear"></div>

<div id="dialog-form" title="Create new user">
    <p class="validateTips">All form fields are required.</p>

    <form>
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
        </fieldset>
    </form>
</div>

<!-- footer starts here -->
<div id="footer">
    <a href="#" class="logo" class="thumbnail" rel="tooltip" data-title="WCSN实验室">
        <img src="<?php echo dirname(Yii::app()->homeUrl) ?>/images/logo.jpg">
    </a>

    Copyright &copy; <?php echo date('Y'); ?> by WCSN..<br/>
    All Rights Reserved.<br/>
    <?php echo Yii::powered(); ?>
</div>
<!-- footer -->

</div>
<!-- page -->

</body>
</html>
