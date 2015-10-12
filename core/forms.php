<?php

class ED_Forms extends ED_Template{

	public function __construct(){
		parent::__construct();
	}

	public function open($action = '', $attributes = array(), $attributes_table = array()){
		static $form;

		$attributes = _attributes_to_string($attributes);

		if (stripos($attributes, 'method=') === FALSE):
			$attributes .= ' method="post"';
		endif;

		$attributes = _attributes_to_string($attributes);
		$attributes_table = _attributes_to_string($attributes_table);

		$form .=  '<form action="' . $action . '"' . $attributes . '>';
		$form .=  '<table class="form-table"' . $attributes_table . '>';
		$form .=  '<tbody>';
		echo $form;
	}

	public function multipart($action = '', $attributes = array(), $attributes_table = array()){
		static $form;

		if (is_string($attributes)):
			$attributes .= ' enctype="multipart/form-data"';
		else:
			$attributes['enctype'] = 'multipart/form-data';
		endif;

		return $this->open($action, $attributes, $attributes_table);
	}

	public function hidden($name, $value = '', $recursing = FALSE){
		static $form;

		if (is_array($name)):
			foreach ($name as $key => $val):
				$form .= '<input type="hidden" name="'.$key.'" value="'.$val."\" />\n";
			endforeach;
		endif;

		if ( ! is_array($name)):
			$form .= '<input type="hidden" name="'.$name.'" value="'.$value."\" />\n";
		endif;
		echo $form;
	}

	public function close($submit_name=NULL, $submit_value=NULL, $submit_extras=NULL){
		static $form;

		$form .= '</tbody>';
		$form .= '</table>';
		
		if ( $submit_name != NULL ):
			$form .= '<p>';
			if ( $extras != NULL ) $extras = ' ' . $extras;
			if ( is_array($th) ):
				$input = 'type="'.$type.'"';
				foreach ($th as $k => $v):
					$input .= $k . '="' . $v .'"';
				endforeach;
			endif;
			$form .= '<input name="' . $submit_name . '" value="' . $submit_value . '" class="button button-primary" ' . $submit_extras . 'type="submit">';
			$form .= '</p>';
		endif;
		
		$form .= '</form>';

		echo $form;
	}

	public function input($th=NULL, $name=NULL, $value=NULL, $extras=NULL, $type='text', $label=NULL){
		static $form;

		if ( $extras != NULL ) $extras = ' ' . $extras;
		if ( is_array($th) ):
			$input = 'type="'.$type.'"';
			foreach ($th as $k => $v):
				$input .= $k . '="' . $v .'"';
			endforeach;
		endif;
		$form .= '<tr>';
			if ( ! is_array($th) ):
				$form .= '<th scope="row">' . $th . '</th>';

			else:
				$form .= '<th scope="row">' . $th['label'] . '</th>';
			endif;
			$form .= '<td>';
			if ( ! is_array($th) ):
				$form .= ($label != NULL) ?  '<label>' : NULL;
				$form .= '<input name="' . $name . '" value="' . $value . '" ' . $extras . 'type="' .$type. '">';
				$form .= ($label != NULL) ?  $label . '</label>' : NULL;
			else:
				$form .= ($label != NULL) ?  '<label>' : NULL;
				$form .= '<input ' . $input . '>';
				$form .= ($label != NULL) ?  $label . '</label>' : NULL;
			endif;
			$form .= '</td>';
		$form .= '</tr>';

		echo $form;
	}

	public function text($th=NULL, $name=NULL, $value=NULL, $extras=NULL, $type='text'){
		$this->input($th, $name, $value, 'class="regular-text" '.$extras, 'text');
	}

	public function url($th=NULL, $name=NULL, $value=NULL, $extras=NULL){
		$this->input($th, $name, $value, 'class="regular-text code" '.$extras, 'url');
	}

	public function email($th=NULL, $name=NULL, $value=NULL, $extras=NULL){
		$this->input($th, $name, $value, 'class="regular-text ltr"'.$extras, 'email');
	}

	public function password($th=NULL, $name=NULL, $value=NULL, $extras=NULL){
		$this->input($th, $name, $value, $extras, 'password');
	}

	public function number($th=NULL, $name=NULL, $value=NULL, $extras=NULL){
		$this->input($th, $name, $value, 'class="small-text" '.$extras, 'number');
	}

	public function checkbox($th=NULL, $name=NULL, $value=NULL, $extras=NULL, $type=NULL, $label=NULL){
		$this->input($th, $name, $value, $extras, 'checkbox', $label);
	}

	public function file($th=NULL, $name=NULL, $value=NULL, $extras=NULL, $type=NULL, $label=NULL){
		$this->input($th, $name, $value, $extras, 'file');
	}

	public function submit($name=NULL, $value=NULL, $extras=NULL){
		static $form;

		if ( $extras != NULL ) $extras = ' ' . $extras;
		if ( is_array($th) ):
			$input = 'type="'.$type.'"';
			foreach ($th as $k => $v):
				$input .= $k . '="' . $v .'"';
			endforeach;
		endif;
		$form .= '<tr>';
			$form .= '<td>';
			if ( ! is_array($th) ):
				$form .= '<input name="' . $name . '" value="' . $value . '" class="button button-primary" ' . $extras . 'type="submit">';
			else:
				$form .= ($label != NULL) ?  '<label>' : NULL;
				$form .= '<input ' . $input . '>';
				$form .= ($label != NULL) ?  $label . '</label>' : NULL;
			endif;
			$form .= '</td>';
		$form .= '</tr>';

		echo $form;
	}

	public function textarea($th=NULL, $name=NULL, $value=NULL, $extras=NULL, $type='text'){
		static $form;

		if ( $extras != NULL ) $extras = ' ' . $extras;
		if ( is_array($th) ):
			$input = 'type="'.$type.'"';
			foreach ($th as $k => $v):
				$input .= $k . '="' . $v .'"';
			endforeach;
		endif;
		$form .= '<tr>';
			if ( ! is_array($th) ):
				$form .= '<th scope="row">' . $th . '</th>';
			else:
				$form .= '<th scope="row">' . $th['label'] . '</th>';
			endif;
			$form .= '<td>';
			if ( ! is_array($th) ):
				$form .= '<textarea name="' . $name . '" rows="10" cols="50" class="regular-text code" ' . $extras . '>' . $value . '</textarea>';
			else:
				$form .= '<textarea ' . $input . '>' . $value . '</textarea>';
			endif;
			$form .= '</td>';
		$form .= '</tr>';

		echo $form;
	}

	public function radio($th=NULL, $name=NULL, $options=array(), $extras=NULL, $br=TRUE){
		static $form;

		if ( $extras != NULL ) $extras = ' ' . $extras;
		$form .= '<tr>';
			$form .= '<th scope="row">' . $th . '</th>';
			$form .= '<td>';
			foreach ( $options as $value => $label ):
				if ( $br ) $form .= '<p>';
				$form .= '<label>';
				$form .= '<input name="' . $name . '" value="' . $value . '" ' . $extras . 'type="radio"></input>';
				$form .= $label . '</label>';
				if ( $br ) $form .= '</p>';
			endforeach;
			$form .= '</td>';
		$form .= '</tr>';

		echo $form;
	}

	public function select($th=NULL, $name=NULL, $options=array(), $defaut_value=NULL, $extras=NULL){
		static $form;

		if ( $extras != NULL ) $extras = ' ' . $extras;
		$form .= '<tr>';
			$form .= '<th scope="row">' . $th . '</th>';
			$form .= '<td>';
			$form .= '<select name="' . $name . '"' . $extras . '>';
			if ( $defaut_value == NULL ):
				$form .= '<option value=""></option>';
			endif;
			foreach ( $options as $value => $label ):
				$form .= '<option value="' . $value . '"';
				$form .= ( $defaut_value != NULL && $defaut_value == $value ) ? ' selected="selected"' : '';
				$form .= '>' . $label. '</option>';
			endforeach;
			$form .= '</select>';
			$form .= '</td>';
		$form .= '</tr>';

		echo $form;
	}



}

/*
<form action="options.php" method="post">

			<input name="option_page" value="bbpress" type="hidden">
			<input name="action" value="update" type="hidden"><input id="_wpnonce" name="_wpnonce" value="811091e992" type="hidden"><input name="_wp_http_referer" value="/wordpress/wp-admin/options-general.php?page=bbpress" type="hidden">
			<h3>Forum User Settings</h3>

	<p>Setting time limits and other user posting capabilities</p>

<table class="form-table"><tbody>

<tr><th scope="row">Disallow editing after</th><td>
	<input name="_bbp_edit_lock" id="_bbp_edit_lock" min="0" step="1" value="5" class="small-text" type="number">
	<label for="_bbp_edit_lock">minutes</label>

</td></tr><tr><th scope="row">Throttle posting every</th><td>
	<input name="_bbp_throttle_time" id="_bbp_throttle_time" min="0" step="1" value="10" class="small-text" type="number">
	<label for="_bbp_throttle_time">seconds</label>

</td></tr><tr><th scope="row">Anonymous posting</th><td>
	<input name="_bbp_allow_anonymous" id="_bbp_allow_anonymous" value="1" type="checkbox">
	<label for="_bbp_allow_anonymous">Allow guest users without accounts to create topics and replies</label>

</td></tr><tr><th scope="row">Auto role</th><td>
	<label for="_bbp_allow_global_access">
		<input name="_bbp_allow_global_access" id="_bbp_allow_global_access" value="1" checked="checked" type="checkbox">
		Automatically give registered visitors the 
	</label>
	<label for="_bbp_default_role">
		<select name="_bbp_default_role" id="_bbp_default_role">
		
			<option value="bbp_keymaster">Keymaster</option>

		
			<option value="bbp_moderator">Moderator</option>

		
			<option selected="selected" value="bbp_participant">Participant</option>

		
			<option value="bbp_spectator">Spectator</option>

		
			<option value="bbp_blocked">Blocked</option>

				</select>

	 forum role	</label>

</td></tr></tbody></table><h3>Forum Features</h3>

	<p>Forum features that can be toggled on and off</p>

<table class="form-table"><tbody><tr><th scope="row">Revisions</th><td>
	<input name="_bbp_allow_revisions" id="_bbp_allow_revisions" value="1" checked="checked" type="checkbox">
	<label for="_bbp_allow_revisions">Allow topic and reply revision logging</label>

</td></tr><tr><th scope="row">Favorites</th><td>
	<input name="_bbp_enable_favorites" id="_bbp_enable_favorites" value="1" checked="checked" type="checkbox">
	<label for="_bbp_enable_favorites">Allow users to mark topics as favorites</label>

</td></tr><tr><th scope="row">Subscriptions</th><td>
	<input name="_bbp_enable_subscriptions" id="_bbp_enable_subscriptions" value="1" checked="checked" type="checkbox">
	<label for="_bbp_enable_subscriptions">Allow users to subscribe to forums and topics</label>

</td></tr><tr><th scope="row">Topic tags</th><td>
	<input name="_bbp_allow_topic_tags" id="_bbp_allow_topic_tags" value="1" checked="checked" type="checkbox">
	<label for="_bbp_allow_topic_tags">Allow topics to have tags</label>

</td></tr><tr><th scope="row">Search</th><td>
	<input name="_bbp_allow_search" id="_bbp_allow_search" value="1" checked="checked" type="checkbox">
	<label for="_bbp_allow_search">Allow forum wide search</label>

</td></tr><tr><th scope="row">Post Formatting</th><td>
	<input name="_bbp_use_wp_editor" id="_bbp_use_wp_editor" value="1" checked="checked" type="checkbox">
	<label for="_bbp_use_wp_editor">Add toolbar &amp; buttons to textareas to help with HTML formatting</label>

</td></tr><tr><th scope="row">Auto-embed links</th><td>
	<input name="_bbp_use_autoembed" id="_bbp_use_autoembed" value="1" checked="checked" type="checkbox">
	<label for="_bbp_use_autoembed">Embed media (YouTube, Twitter, Flickr, etc...) directly into topics and replies</label>

</td></tr><tr><th scope="row">Reply Threading</th><td>
	<label for="_bbp_allow_threaded_replies">
		<input name="_bbp_allow_threaded_replies" id="_bbp_allow_threaded_replies" value="1" type="checkbox">
		Enable threaded (nested) replies 
	</label>
	<label for="_bbp_thread_replies_depth">
		<select name="_bbp_thread_replies_depth" id="_bbp_thread_replies_depth">
		
			<option value="2" selected="selected">2</option>

		
			<option value="3">3</option>

		
			<option value="4">4</option>

		
			<option value="5">5</option>

		
			<option value="6">6</option>

		
			<option value="7">7</option>

		
			<option value="8">8</option>

		
			<option value="9">9</option>

		
			<option value="10">10</option>

				</select>

	 levels deep	</label>

</td></tr></tbody></table><h3>Topics and Replies Per Page</h3>

	<p>How many topics and replies to show per page</p>

<table class="form-table"><tbody><tr><th scope="row">Topics</th><td>
	<input name="_bbp_topics_per_page" id="_bbp_topics_per_page" min="1" step="1" value="15" class="small-text" type="number">
	<label for="_bbp_topics_per_page">per page</label>

</td></tr><tr><th scope="row">Replies</th><td>
	<input name="_bbp_replies_per_page" id="_bbp_replies_per_page" min="1" step="1" value="15" class="small-text" type="number">
	<label for="_bbp_replies_per_page">per page</label>

</td></tr></tbody></table><h3>Topics and Replies Per RSS Page</h3>

	<p>How many topics and replies to show per RSS page</p>

<table class="form-table"><tbody><tr><th scope="row">Topics</th><td>
	<input name="_bbp_topics_per_rss_page" id="_bbp_topics_per_rss_page" min="1" step="1" value="25" class="small-text" type="number">
	<label for="_bbp_topics_per_rss_page">per page</label>

</td></tr><tr><th scope="row">Replies</th><td>
	<input name="_bbp_replies_per_rss_page" id="_bbp_replies_per_rss_page" min="1" step="1" value="25" class="small-text" type="number">
	<label for="_bbp_replies_per_rss_page">per page</label>

</td></tr></tbody></table><h3>Forum Root Slug</h3>

	<p>Customize your Forums root. Partner with a WordPress Page and use Shortcodes for more flexibility.</p>

<table class="form-table"><tbody><tr><th scope="row">Forum Root</th><td>
        <input name="_bbp_root_slug" id="_bbp_root_slug" class="regular-text code" value="forums" type="text">

</td></tr><tr><th scope="row">Forum Prefix</th><td>
	<input name="_bbp_include_root" id="_bbp_include_root" value="1" checked="checked" type="checkbox">
	<label for="_bbp_include_root">Prefix all forum content with the Forum Root slug (Recommended)</label>

</td></tr><tr><th scope="row">Forum root should show</th><td>
	<select name="_bbp_show_on_root" id="_bbp_show_on_root">

		
			<option selected="selected" value="forums">Forum Index</option>

		
			<option value="topics">Topics by Freshness</option>

		
	</select>

</td></tr></tbody></table><h3>Single Forum Slugs</h3>

	<p>Custom slugs for single forums, topics, replies, tags, views, and search.</p>

<table class="form-table"><tbody><tr><th scope="row">Forum</th><td>
	<input name="_bbp_forum_slug" id="_bbp_forum_slug" class="regular-text code" value="forum" type="text">

</td></tr><tr><th scope="row">Topic</th><td>
	<input name="_bbp_topic_slug" id="_bbp_topic_slug" class="regular-text code" value="topic" type="text">

</td></tr><tr><th scope="row">Topic Tag</th><td>
	<input name="_bbp_topic_tag_slug" id="_bbp_topic_tag_slug" class="regular-text code" value="topic-tag" type="text">

</td></tr><tr><th scope="row">Topic View</th><td>
	<input name="_bbp_view_slug" id="_bbp_view_slug" class="regular-text code" value="view" type="text">

</td></tr><tr><th scope="row">Reply</th><td>
	<input name="_bbp_reply_slug" id="_bbp_reply_slug" class="regular-text code" value="reply" type="text">

</td></tr><tr><th scope="row">Search</th><td>
	<input name="_bbp_search_slug" id="_bbp_search_slug" class="regular-text code" value="search" type="text">

</td></tr></tbody></table><h3>Forum User Slugs</h3>

	<p>Customize your user profile slugs.</p>

<table class="form-table"><tbody><tr><th scope="row">User Base</th><td>
	<input name="_bbp_user_slug" id="_bbp_user_slug" class="regular-text code" value="users" type="text">

</td></tr><tr><th scope="row">Topics Started</th><td>
	<input name="_bbp_topic_archive_slug" id="_bbp_topic_archive_slug" class="regular-text code" value="topics" type="text">

</td></tr><tr><th scope="row">Replies Created</th><td>
	<input name="_bbp_reply_archive_slug" id="_bbp_reply_archive_slug" class="regular-text code" value="replies" type="text">

</td></tr><tr><th scope="row">Favorite Topics</th><td>
	<input name="_bbp_user_favs_slug" id="_bbp_user_favs_slug" class="regular-text code" value="favorites" type="text">

</td></tr><tr><th scope="row">Topic Subscriptions</th><td>
	<input name="_bbp_user_subs_slug" id="_bbp_user_subs_slug" class="regular-text code" value="subscriptions" type="text">

</td></tr></tbody></table><h3>BuddyPress Integration</h3>

	<p>Forum settings for BuddyPress</p>

<table class="form-table"><tbody><tr><th scope="row">Enable Group Forums</th><td>
	<input name="_bbp_enable_group_forums" id="_bbp_enable_group_forums" value="1" checked="checked" type="checkbox">
	<label for="_bbp_enable_group_forums">Allow BuddyPress Groups to have their own forums</label>

</td></tr><tr><th scope="row">Group Forums Parent</th><td><select name="_bbp_group_forums_root_id" id="_bbp_group_forums_root_id" tabindex="101">
	<option value="" class="level-0">— Forum root —</option></select>
	<label for="_bbp_group_forums_root_id">is the parent for all group forums</label>
	<p class="description">Using the Forum Root is not recommended. Changing this does not move existing forums.</p>

</td></tr></tbody></table>
			<p class="submit">
				<input name="submit" class="button-primary" value="Save Changes" type="submit">
			</p>
		</form>
*/