<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
//Yii::app()->bootstrap->register();
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'WCSN',

    // preloading 'log' component
    'preload' => array('log'),
    'theme' => 'bootstrap',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    'modules' => array(
        'gii' => array(
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            'ipFilters' => array('10.129.196.60', '127.0.0.1', '::1'),
            // 'newFileMode'=>0666,
            // 'newDirMode'=>0777,
        ),
        'check1nm',

        // uncomment the following to enable the Gii tool
        /*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'Enter Your Password Here',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        */
    ),

    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            //'showScriptName' => false,
//            'urlFormat' => 'path',
//
//            'rules' => array(
//                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
////                '<controller:\w+>/<id:\d+>' => '<controller>/view',
////                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
////                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
//            ),
        ),

        'db' => array(
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
        ),
        // uncomment the following to use a MySQL database

        'mysqldb' => array(
            'connectionString' => 'mysql:host=localhost;dbname=check1n',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'ss1013',
            'charset' => 'utf8',
        ),

//        'db'=>array(
//            'connectionString' => 'mysql:host=10.134.44.84;dbname=query',
//            'emulatePrepare' => true,
//            'username' => 'root',
//            'password' => 'root',
//            'charset' => 'utf8',
//        ),

//        'db'=>array(
//          'connectionString' => "odbc:driver={microsoft access driver (*.mdb)};dbq=". dirname(__FILE__) . '/../data/att2000.mdb',
//        ),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require('params.php'),
);