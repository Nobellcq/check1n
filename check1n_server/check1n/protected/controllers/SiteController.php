<?php

class SiteController extends Controller
{
    public $list_item =   array(
//                array('title'=>'首  页','url'=>'http://localhost/yiiHello/yiiHello/index.php?r=site/contain'),
//                array('title'=>'收件箱','url'=>'http://10.136.115.194/yiiHello/index.php?r=NewsManageModule/default/index'),
//        array('title'=>'发件箱','url'=>'/yiiHello/yiiHello/index.php?r=site/wrap&url=http://www.sogou.com'),
//                array('title'=>'发件箱','url'=>'http://localhost/yiiHello/yiiHello/index.php?r=site/contain&url=http://spider01.venation.zw.vm.sogou-op.org/eventlist.php'),
            );

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->renderPartial('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->renderPartial('contact',array('model'=>$model),false ,true);
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionContain($url = 'http://www.sogou.com'){
        $this->renderPartial('contain',array('url'=>$url),false, true);
    }

    public function actionWrap($url = 'http://www.sogou.com'){
        $this->renderPartial('wrap',array('url'=>$url),false,true);
    }

    public function getTabularFormTabs($form, $model)
    {
        $tabs = array();
        $count = 0;
        foreach (array('en'=>'English', 'fi'=>'Finnish', 'sv'=>'Swedish') as $locale => $language)
        {
            $tabs[] = array(
                'active'=>$count++ === 0,
                'label'=>$language,
                'content'=>$this->renderPartial('_tabular', array('form'=>$form, 'model'=>$model, 'locale'=>$locale, 'language'=>$language), false, true),
            );
        }
        return $tabs;
    }
}