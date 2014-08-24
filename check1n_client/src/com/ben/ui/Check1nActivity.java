package com.ben.ui;

import java.util.HashSet;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import cn.jpush.android.api.JPushInterface;

import com.ben.check1n.R;
import com.ben.config.UserConfig;
import com.example.jpushdemo.PushSetActivity;

public class Check1nActivity extends Activity implements OnClickListener{
	private Button setTagButton;
	private Button historyButton;
	private Button recordButton;
	private TextView tagsView;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.check1n_main);
		
		initView();
	}

	@Override
	protected void onStart() {
		super.onStart();
	}

	@Override
	protected void onResume() {
		JPushInterface.onResume(this);
		super.onResume();
	}

	@Override
	protected void onPause() {
		JPushInterface.onPause(this);
		super.onPause();
	}

	@Override
	protected void onStop() {
		super.onStop();
	}

	private void initView() {
		setTagButton = (Button) findViewById(R.id.setTag);
		historyButton = (Button) findViewById(R.id.history);
		recordButton = (Button) findViewById(R.id.record);
		tagsView = (TextView) findViewById(R.id.tags_view);
		
		setTagButton.setOnClickListener(this);
		historyButton.setOnClickListener(this);
		recordButton.setOnClickListener(this);
		
		refreshTags();
	}

	private void refreshTags() {
		HashSet<String> tags = UserConfig.getInstance().getTags();
		if(tags.isEmpty()){
			tagsView.setText(getString(R.string.tags_text_none));
		}else{
			tagsView.setText(String.format(getString(R.string.tags_text), UserConfig.tagsToString(tags)));	
		}
	}
	
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.history:
			Intent intent0 = new Intent(Check1nActivity.this, HistoryActivity.class);
			startActivity(intent0);
			break;
		case R.id.setTag:
			Intent intent1 = new Intent(Check1nActivity.this, PushSetActivity.class);
			startActivityForResult(intent1,100);
			break;
		case R.id.record:
			Intent intent2 = new Intent(Check1nActivity.this, Check1nWebActivity.class);
			startActivity(intent2);
			break;
		}		
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if(requestCode == 100 && resultCode == 101){
			refreshTags();
		}
		super.onActivityResult(requestCode, resultCode, data);
	}

	
}
