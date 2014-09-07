<?php
### Tells WordPress to load the WordPress theme and output it.
define( 'WP_USE_THEMES', false );

### Loads the WordPress Environment and Template
require( './wp-blog-header.php' );

### Remove WordPress Footer
remove_all_actions( 'wp_footer' );
remove_all_actions( 'loop_end' );

### Set Header To WML
header( 'Content-Type: text/vnd.wap.wml;charset=utf-8' );

### Echo XML
echo '<?xml version="1.0" encoding="utf-8"?'.'>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD WML 2.0//EN" "http://www.wapforum.org/dtd/wml20.dtd">
<wml>
	<card id="WordPress" title="<?php bloginfo_rss('name'); ?>">
		<?php if(empty($_GET['id']) && intval($_GET['id']) === 0): ?>
			<?php query_posts( array( 'posts_per_page' => 20 ) ); ?>
			<?php if(have_posts()): ?>
				<?php while (have_posts()): the_post(); ?>
					<p>
						<?php the_time(get_option('date_format').' ('.get_option('time_format').')'); ?><br />
						- <a href="<?php bloginfo('siteurl'); ?>/wap.php?id=<?php the_id(); ?>"><?php the_title_rss(); ?></a>
					</p>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php else : ?>
			<?php query_posts( array( 'p' => intval( $_GET['id'] ) ) ); ?>
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<p>&gt; <?php the_title_rss(); ?></p>
					<p>&gt; <?php the_time(get_option('date_format').' ('.get_option('time_format').')'); ?></p>
					<p>&gt; In <?php echo strip_tags(get_the_category_list(', ')); ?></p>
					<p>&gt; By <?php the_author(); ?></p>
					<p>&gt; <a href="wap-comments.php?id=<?php the_ID(); ?>"><?php comments_number("No Comments", "1 Comment", "% Comments"); ?></a></p>
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