<?php bb_get_header(); ?>

<dl role="main" class="left">
	<dt><?php _e( 'Registered Users', 'bb-mystique' ); ?></dt>
	<dd><strong><?php bb_total_users(); ?></strong></dd>
	
	<dt><?php _e( 'Forums', 'bb-mystique' ); ?></dt>
	<dd><strong><?php total_forums(); ?></strong></dd>
	
	<dt><?php _e( 'Topics', 'bb-mystique' ); ?></dt>
	<dd><strong><?php total_topics(); ?></strong></dd>
	
	<dt><?php _e( 'Posts', 'bb-mystique' ); ?></dt>
	<dd><strong><?php total_posts(); ?></strong></dd>
<?php do_action( 'bb_stats_left' ); ?>
</dl>

<div class="right">
<?php if ( $popular ) : ?>
	<h3><?php _e( 'Most Popular Topics', 'bb-mystique' ); ?></h3>
	<ol>
<?php foreach ( $popular as $topic ) : ?>
		<li><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a> &#8212; <?php printf( _n( '%s post', '%s posts', get_topic_posts() ), bb_number_format_i18n( get_topic_posts() ) ); ?></li>
<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'bb_stats_right' ); ?>
</div>

<?php bb_get_footer(); ?>
