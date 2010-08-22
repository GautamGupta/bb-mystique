<?php bb_get_header(); ?>

<?php if ( $forums ) : ?>

<div id="discussions">
	<?php bb_kakumei_topics_table(); /* Open up functions.php to customize the table */ ?>
	
	<?php if ( bb_forums() ) : ?>
	
	<?php do_action( 'bb_before_forum_table' ); ?>
	
	<h2><?php _e( 'Forums', 'bb-mystique' ); ?></h2>
	<table id="forumlist">
		<thead>
			<tr>
				<th><?php _e( 'Main Theme', 'bb-mystique' ); ?></th>
				<th><?php _e( 'Topics', 'bb-mystique' ); ?></th>
				<th><?php _e( 'Posts', 'bb-mystique' ); ?></th>
				<?php do_action( 'bb_forum_table_thead' ); ?>
			</tr>
		</thead>
		
		<tbody>
			<?php while ( bb_forum() ) : ?>
			<?php if ( bb_get_forum_is_category() ) : ?>
			<tr<?php bb_forum_class( 'bb-category' ); ?>>
				<td colspan="3"><?php bb_forum_pad( '<div class="nest">' ); ?><a href="<?php forum_link(); ?>"><?php forum_name(); ?></a><?php forum_description( array( 'before' => '<small> &#8211; ', 'after' => '</small>' ) ); ?><?php bb_forum_pad( '</div>' ); ?></td>
				<?php do_action( 'bb_forum_table_td', get_forum_id() ); ?>
			</tr>
			<?php continue; endif; ?>
			<tr<?php bb_forum_class(); ?>>
				<td><?php bb_forum_pad( '<div class="nest">' ); ?><a href="<?php forum_link(); ?>"><?php forum_name(); ?></a><?php forum_description( array( 'before' => '<small> &#8211; ', 'after' => '</small>' ) ); ?><?php bb_forum_pad( '</div>' ); ?></td>
				<td class="num"><?php forum_topics(); ?></td>
				<td class="num"><?php forum_posts(); ?></td>
				<?php do_action( 'bb_forum_table_td', get_forum_id() ); ?>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
	
	<?php do_action( 'bb_before_forum_table' ); ?>
	<?php endif; // bb_forums() ?>
	
</div>
<?php else : //$forums ?>
	<?php post_form( array( 'h2' => __( 'Start New Topic', 'bb-mystique' ) . '<span class="new-topic"> &#8212; <a href="' . bb_get_uri() . '">' . __( 'cancel', 'bb-mystique' ) . '</a></span>' ) ); ?>
<?php endif; //$forums ?>

<?php bb_get_footer(); ?>
