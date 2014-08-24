package com.ben.ui;

import android.app.Activity;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ProgressBar;

import com.ben.check1n.R;

public class Check1nWebActivity extends Activity {
	private WebView webView;
	private ProgressBar progressBar;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.webmain);
		webView = (WebView) findViewById(R.id.webview);
		progressBar = (ProgressBar) findViewById(R.id.progressbar);
		
		WebSettings settings = webView.getSettings();
		settings.setJavaScriptEnabled(true);
		webView.setWebViewClient(new WebViewClient() {
			@Override
			public void onPageStarted(WebView view, String url, Bitmap favicon) {
				// super.onPageStarted(view, url, favicon);
				progressBar.setVisibility(View.VISIBLE);
				System.out.println(url);
				super.onPageStarted(view, url, favicon);
			}

			@Override
			public void onPageFinished(WebView view, String url) {
				super.onPageFinished(view, url);
				progressBar.setVisibility(View.GONE);
			}
		});
		webView.loadUrl("http://10.103.26.229/check1n/index.php?r=check1nm/default/index");
	}

}
