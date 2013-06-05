<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.1 Plugin: WP-Wap 2.30										|
|	Copyright (c) 2007 Lester "GaMerZ" Chan									|
|																							|
|	File Written By:																	|
|	- Lester "GaMerZ" Chan															|
|	- http://lesterchan.net															|
|																							|
|	File Information:																	|
|	- WAP Friendly Page	For Blog Comments									|
|	- wap-comments.php															|
|																							|
+----------------------------------------------------------------+
*/


### We Need RSS
if (empty($wp)) {
	require_once('wp-config.php');
	wp('feed=rss');
}

### Set Header To WML
header('Content-Type: text/vnd.wap.wml;charset=utf-8');

### Get Post ID
$p = intval($_GET['p']);

### If $p Is Not Empty
if ($p > 0) {
	$comments = $wpdb->get_results("SELECT comment_ID, comment_author, comment_author_email, comment_author_url, comment_date,	comment_content, comment_post_ID, $wpdb->posts.ID, $wpdb->posts.post_password FROM $wpdb->comments LEFT JOIN $wpdb->posts ON comment_post_ID = ID WHERE comment_post_ID = '$p' AND $wpdb->comments.comment_approved = '1' AND $wpdb->posts.post_status = 'publish' AND post_date < '".current_time('mysql')."' ORDER BY comment_date");
	$post = $wpdb->get_row("SELECT post_title, comment_status FROM $wpdb->posts WHERE ID = '$p' AND post_date < post_date < '".current_time('mysql')."' AND post_status = 'publish'");
### Else Display Last 10 Comments
} else {
	$comments = $wpdb->get_results("SELECT comment_ID, comment_author, comment_author_email, comment_author_url, comment_date, comment_content, comment_post_ID, $wpdb->posts.ID, $wpdb->posts.post_password FROM $wpdb->comments LEFT JOIN $wpdb->posts ON comment_post_id = id WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->comments.comment_approved = '1' AND post_date < '".current_time('mysql')."' ORDER BY comment_date DESC LIMIT 10");
	$post = $wpdb->get_row("SELECT post_title, comment_status FROM $wpdb->posts WHERE post_date < '".current_time('mysql')."' AND post_status = 'publish' ORDER BY post_date DESC");
}

### Echo XML
echo '<?xml version="1.0" encoding="utf-8"?'.'>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD WML 2.0//EN" "http://www.wapforum.org/dtd/wml20.dtd">
<wml>
<card id="WordPress" title="<?php bloginfo_rss('name'); ?>">
<p>Comments On <?php the_title_rss(); ?></p>
<br />
<?php if ($comments) : ?>
	<?php foreach ($comments as $comment) : ?>
			<p>&gt; <?php comment_author_rss() ?></p>
			<p>&gt; <?php comment_time(get_option('date_format').' ('.get_option('time_format').')'); ?></p>
			<p><?php comment_text_rss() ?></p>
			<br />
	<?php endforeach; ?>
<?php else : ?>
	<?php if ('open' == $post->comment_status) : ?> 
		<p>No Comments Are Posted Yet.</p>
	<?php else : ?>
		<p>Comments Are Closed.</p>
	<?php endif; ?>
<?php endif; ?>
<br />
<p><a href="wap.php">&lt;&lt; <?php bloginfo_rss('name'); ?></a></p>
</card>
</wml>