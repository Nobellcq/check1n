package com.ben;

import cn.jpush.android.api.JPushInterface;

import com.ben.config.UserConfig;
import com.ben.data.DatabaseHelper;

import android.app.Application;

public class Check1nApplication extends Application{

	@Override
	public void onCreate() {
		UserConfig.getInstance().init(this);
		DatabaseHelper.getInstance().init(this);
		initPush();
		super.onCreate();
	}

	// 初始化 JPush。如果已经初始化，但没有登录成功，则执行重新登录。
	private void initPush(){
		JPushInterface.setDebugMode(true); 	// 设置开启日志,发布时请关闭日志
		 JPushInterface.init(getApplicationContext());
	}
}
