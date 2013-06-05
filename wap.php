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
|	- WAP Friendly Page	For Blog Post											|
|	- wap.php																			|
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


### Echo XML
echo '<?xml version="1.0" encoding="utf-8"?'.'>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD WML 2.0//EN" "http://www.wapforum.org/dtd/wml20.dtd">
<wml>
<card id="WordPress" title="<?php bloginfo_rss('name'); ?>">
<?php if(empty($_GET['p'])): ?>
<?php if(have_posts()): ?>
	<?php while (have_posts()): the_post(); ?>
		<p>
			<?php the_time(get_option('date_format').' ('.get_option('time_format').')'); ?><br />
			- <a href="<?php bloginfo('siteurl'); ?>/wap.php?p=<?php the_id(); ?>"><?php the_title_rss(); ?></a>
		</p>
	<?php endwhile; ?>
	<p><?php next_posts_link('&lt;&lt; Previous Entries') ?> | <?php previous_posts_link('Next Entries &gt;&gt;') ?></p>
<?php endif; ?>
<?php else : ?>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<p>&gt; <?php the_title_rss(); ?></p>
			<p>&gt; <?php the_time(get_option('date_format').' ('.get_option('time_format').')'); ?></p>
			<p>&gt; In <?php echo strip_tags(get_the_category_list(', ')); ?></p>
			<p>&gt; By <?php the_author(); ?></p>
			<p>&gt; <a href="wap-comments.php?p=<?php the_ID(); ?>"><?php comments_number("No Comments", "1 Comment", "% Comments"); ?></a></p>
			<p><?php the_content_rss(); ?></p>
		<?php endwhile; ?>
	<?php else : ?>
		<p>No Posts Matched Your Criteria</p>
	<?php endif; ?>
	<br />
	<p><a href="wap.php">&lt;&lt; <?php bloginfo_rss('name'); ?></a></p>
<?php endif; ?>
</card>
</wml>