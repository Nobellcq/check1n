package com.ben.ui;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import android.app.Activity;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;

import com.ben.check1n.R;
import com.ben.data.daoimpl.RecordDao;
import com.ben.data.pojo.Record;

public class HistoryActivity extends Activity implements OnClickListener {
	private ListView list;
	private TextView info;
	private TextView curpageText;
	private SimpleAdapter adapter;
	private ArrayList<HashMap<String, String>> data;
	private RecordDao dao;
	private int curpage = 1;
	private int totalpage = 1;
	private int totalcount = 0;
	private int pageSize = 15;
	
	private String query;
	private EditText queryText;
	private Button search;
	private Button clearSearch;

	private Button firstPage;
	private Button prePage;
	private Button nextPage;
	private Button lastPage;
	
	private Button gotoPage;
	private EditText gotoText;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.history_activity);

		initView();
		initList();
	}

	private void initView() {
		firstPage = (Button) findViewById(R.id.firstpage);
		prePage = (Button) findViewById(R.id.prepage);
		nextPage = (Button) findViewById(R.id.nextpage);
		lastPage = (Button) findViewById(R.id.lastpage);
		gotoPage = (Button) findViewById(R.id.goto_btn);

		firstPage.setOnClickListener(this);
		prePage.setOnClickListener(this);
		nextPage.setOnClickListener(this);
		lastPage.setOnClickListener(this);
		gotoPage.setOnClickListener(this);
		
		gotoText = (EditText)findViewById(R.id.goto_text);
		
		queryText = (EditText) findViewById(R.id.search_text);
		search = (Button)findViewById(R.id.search_btn);
		clearSearch = (Button) findViewById(R.id.clear_btn);
		
		search.setOnClickListener(this);
		clearSearch.setOnClickListener(this);
	}

	private void initList() {
		list = (ListView) findViewById(R.id.recordlist);
		info = (TextView) findViewById(R.id.info);
		data = new ArrayList<HashMap<String, String>>();
		dao = new RecordDao();
		
		List<Record> recordList;
		if(TextUtils.isEmpty(query)){
			totalcount = dao.count();
			totalpage = (int) Math.ceil(totalcount * 1.0 / pageSize);
			info.setText(String.format(getString(R.string.total_pages), totalpage, totalcount));
			recordList = dao.findAll(pageSize, (curpage - 1) * pageSize);	
		}else{
			totalcount = dao.count(new String[]{"userid"}, new Object[]{query});
			totalpage = (int) Math.ceil(totalcount * 1.0 / pageSize);
			info.setText(String.format(getString(R.string.total_pages), totalpage, totalcount));
			recordList = dao.findByKeys(new String[]{"userid"}, new Object[]{query}, pageSize, (curpage - 1) * pageSize);
		}
		
		for (Record r : recordList) {
			HashMap<String, String> map = new HashMap<String, String>();
			map.put("title", r.getUserid());
			map.put("content", r.getTime());
			data.add(map);
		}
		adapter = new SimpleAdapter(this, data, android.R.layout.simple_list_item_2, new String[] { "title", "content" }, new int[] { android.R.id.text1,
				android.R.id.text2 });
		list.setAdapter(adapter);

		curpageText = (TextView)findViewById(R.id.curpage);
		curpageText.setText(String.format(getString(R.string.cur_page), curpage));

	}

	private void refreshList() {

		
		List<Record> recordList;
		if(TextUtils.isEmpty(query)){
			totalcount = dao.count();
			totalpage = (int) Math.ceil(totalcount * 1.0 / pageSize);
			info.setText(String.format(getString(R.string.total_pages), totalpage, totalcount));
			recordList = dao.findAll(pageSize, (curpage - 1) * pageSize);	
		}else{
			totalcount = dao.count(new String[]{"userid"}, new Object[]{query});
			totalpage = (int) Math.ceil(totalcount * 1.0 / pageSize);
			info.setText(String.format(getString(R.string.total_pages), totalpage, totalcount));
			recordList = dao.findByKeys(new String[]{"userid"}, new Object[]{query}, pageSize, (curpage - 1) * pageSize);
		}
		
		data.clear();
		for (Record r : recordList) {
			HashMap<String, String> map = new HashMap<String, String>();
			map.put("title", r.getUserid());
			map.put("content", r.getTime());
			data.add(map);
		}
		curpageText.setText(String.format(getString(R.string.cur_page), curpage));
		adapter.notifyDataSetChanged();
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.firstpage:
			curpage = 1;
			if (totalpage > 1) {
				prePage.setEnabled(false);
				nextPage.setEnabled(true);
			}
			break;
		case R.id.prepage:
			if (curpage > 1) {
				curpage--;
			}
			if (curpage == 1) {
				prePage.setEnabled(false);
			}
			if (curpage == totalpage - 1) {
				nextPage.setEnabled(true);
			}
			break;
		case R.id.lastpage:
			curpage = totalpage;
			if (totalpage > 1) {
				prePage.setEnabled(true);
				nextPage.setEnabled(false);
			}
			break;
		case R.id.nextpage:
			if (curpage < totalpage) {
				curpage++;
			}
			if (curpage == totalpage) {
				nextPage.setEnabled(false);
			}
			if (curpage == 2) {
				prePage.setEnabled(true);
			}
			break;
		case R.id.goto_btn:
			String text = gotoText.getText().toString();
			if(!TextUtils.isEmpty(text)){
				try{
					goToPage(Integer.valueOf(text));
				}catch(Exception e){
					e.printStackTrace();
				}
			}
			break;
		case R.id.search_btn:
			query = queryText.getText().toString();
			break;
		case R.id.clear_btn:
			query =null;
			queryText.setText("");
			break;
		}
		refreshList();
	}
	
	private void goToPage(int page){
		if(page > totalpage){
			page = totalpage;
			gotoText.setText(page+"");
		}
		if(page < 1){
			page =1;
			gotoText.setText(page+"");
		}
		curpage = page;
		if(curpage == totalpage){
			prePage.setEnabled(true);
			nextPage.setEnabled(false);
		}
		if(curpage == 1){
			prePage.setEnabled(false);
			nextPage.setEnabled(true);
		}
		//refreshList();
	}

}
