package com.ben.config;

import java.util.HashSet;
import java.util.Iterator;
import java.util.Set;

import android.content.Context;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.text.TextUtils;

public class UserConfig {
	private final String PREFERENCES_TAGS = "sp_tags";
	private final String KEY_TAGS = "sp_tags_key";
	
	private Context context;
	private SharedPreferences sp;
	private HashSet<String> tags;
	private static UserConfig instance;
	
	private UserConfig(){

	}
	
	public void init(Context context){
		this.context = context;
		sp = context.getSharedPreferences(PREFERENCES_TAGS,Context.MODE_PRIVATE);
		tags = tagsToSet(sp.getString(KEY_TAGS, ""));
	}
	
	public static UserConfig getInstance(){
		if(instance == null){
			instance = new UserConfig();
		}
		return instance;
	}
	
	public void addTag(String tag){
		if(tags.add(tag)){
			save();	
		}
	}
	
	public void removeTag(String tag){
		if(tags.remove(tag)){
			save();
		}
	}
	
	public void updateTags(Set<String> tags){
		this.tags = new HashSet<String>(tags);
		save();
	}
	
	public HashSet<String> getTags(){
		return new HashSet<String>(tags);
	}
	
	public String getTagsString(){
		return tagsToString(tags);
	}
	
	public void save(){
		Editor editor = sp.edit();
		editor.putString(KEY_TAGS, tagsToString(tags));
		editor.commit();
	}
	
	public static String tagsToString(Set<String> tags){
		StringBuilder sb = new StringBuilder();
		Iterator<String> it = tags.iterator();
		if(it.hasNext()){
			sb.append(it.next());
		}
		while(it.hasNext()){
			sb.append(",").append(it.next());
		}
		return sb.toString();
	}
	
	public static HashSet<String> tagsToSet(String tagsString){
		HashSet<String> tagsSet = new HashSet<String>();
		if(!TextUtils.isEmpty(tagsString)){
			String[] tagsArr = tagsString.split(",");
			for(String tag : tagsArr){
				tagsSet.add(tag);
			}	
		}
		return tagsSet;
	}
}
