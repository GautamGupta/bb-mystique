<?php bb_get_header(); ?>

<div class="stats">
	<h3><?php _e( 'Quick Stats', 'bb-mystique' ); ?></h3>

	<table role="main">
		<tr>
			<th scope="row"><?php _e( 'Registered Users', 'bb-mystique' ); ?></th>
			<td><?php bb_total_users(); ?></td>
		</tr>

		<tr>
			<th scope="row"><?php _e( 'Forums', 'bb-mystique' ); ?></th>
			<td><?php total_forums(); ?></td>
		</tr>

		<tr>
			<th scope="row"><?php _e( 'Topics', 'bb-mystique' ); ?></th>
			<td><?php total_topics(); ?></td>
		</tr>

		<tr>
			<th scope="row"><?php _e( 'Posts', 'bb-mystique' ); ?></th>
			<td><?php total_posts(); ?></td>
		</tr>

	<?php do_action( 'bb_stats_left' ); ?>
	</table>
</div>

<div class="statspop">
<?php if ( $popular ) : ?>
	<h3><?php _e( 'Most Popular Topics', 'bb-mystique' ); ?></h3>
	<ol>
<?php foreach ( $popular as $topic ) : ?>
		<li><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a> &#8212; <?php printf( _n( '%s post', '%s posts', get_topic_posts() ), bb_number_format_i18n( get_topic_posts() ) ); ?></li>
<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'bb_stats_right' ); ?>
</div>

<?php bb_get_footer(); ?>
