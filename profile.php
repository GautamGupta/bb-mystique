<?php bb_get_header(); ?>

<?php if ( $updated ) : ?>
	<div class="notice">
		<p><?php _e( 'Profile updated.', 'bb-mystique' ); ?> <a href="<?php profile_tab_link( $user_id, 'edit' ); ?>"><?php esc_attr_e( 'Edit again &raquo;', 'bb-mystique' ); ?></a></p>
	</div>
<?php endif; ?>

<div class="vcard" role="main">

<?php if ( $avatar = bb_get_avatar( $user->ID ) ) : ?>
	<div id="useravatar"><?php echo $avatar; ?></div>
<?php unset( $avatar ); endif; ?>

	<h2 id="userlogin">
		<span class="fn"><?php echo get_user_display_name( $user->ID ); ?></span> <small>(<span class="nickname"><?php echo get_user_name( $user->ID ); ?></span>)</small>
	</h2>
	
	<p>
		<?php _e( 'This is how your profile appears to a logged in member.', 'bb-mystique' ); ?>

<?php if ( bb_current_user_can( 'edit_user', $user->ID ) ) : ?>
		<?php printf( __( 'You may <a href="%s">edit this information</a>.', 'bb-mystique' ), esc_attr( get_profile_tab_link( $user_id, 'edit' ) ) ); ?>
<?php endif; ?>
	</p>

<?php if ( bb_current_user_can( 'edit_favorites_of', $user->ID ) ) : ?>
	<p><?php printf( __( 'You can also <a href="%1$s">manage your favorites</a> and subscribe to your favorites&#8217; <a href="%2$s"><abbr title="Really Simple Syndication">RSS</abbr> feed</a>.', 'bb-mystique' ), esc_attr( get_favorites_link() ), esc_attr( get_favorites_rss_link() ) ); ?></p>
<?php endif; ?>

<div class="clear"></div>

<?php bb_profile_data(); ?>

</div>

<h3 id="useractivity"><?php _e( 'User Activity', 'bb-mystique' ) ?></h3>

<div id="user-replies" class="user-recent">
	<?php do_action( 'bb_topics_above_table_before_heading', 'profile-user-recent-replies' /* type */, $posts ); ?>
	<?php if ( $posts ) : ?>
	<h4><?php _e( 'Recent Replies', 'bb-mystique' ); ?></h4>
	<?php do_action( 'bb_topics_above_table', 'profile-user-recent-replies' /* type */, $posts ); ?>
	<table id="latest">
		<thead>
			<tr>
				<th><?php _e( 'Topic', 'bb-mystique' ); ?></th>
				<th class="date"><?php if ( $user->ID == bb_get_current_user_info( 'id' ) ) _e( 'You Last Replied', 'bb-mystique' ); else _e( 'User Last Replied', 'bb-mystique' ); ?></th>
				<th class="date"><?php _e( 'Most Recent Reply', 'bb-mystique' ); ?></th>
				<?php do_action( 'bb_topics_thead', 'profile-user-recent-replies' /* type */, $posts ); ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $posts as $bb_post ) : $topic = get_topic( $bb_post->topic_id ); ?>
			<tr<?php alt_class( 'replies' ); ?>>
				<td><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></td>
				<td class="date"><a href="<?php post_link(); ?>"><?php bb_post_time(); ?> <?php _e( 'ago', 'bb-mystique' ); ?></a></td>
				<td class="date">
					<?php if ( bb_get_post_time( 'timestamp' ) < get_topic_time( 'timestamp' ) ) { ?>
					<a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?> <?php _e( 'ago', 'bb-mystique' ); ?></a>
					<?php } else { ?> - <?php } ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php else : if ( $page ) : ?>
	<p><?php _e( 'No more replies.', 'bb-mystique' ); ?></p>
	<?php else : ?>
	<p><?php _e( 'No replies yet.', 'bb-mystique' ) ?></p>
	<?php endif; endif; ?>
	
</div>

<div id="user-threads" class="user-recent">
	<h4><?php _e( 'Topics Started', 'bb-mystique' ); ?></h4>
	<?php if ( $topics ) : ?>
	<table id="latest">
		<thead>
			<tr>
				<th><?php _e( 'Topic', 'bb-mystique' ); ?></th>
				<th class="date"><?php _e( 'Started', 'bb-mystique' ); ?></th>
				<th class="date"><?php _e( 'Most Recent Reply', 'bb-mystique' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $topics as $topic ) : ; ?>
			<tr<?php alt_class( 'topics' ); ?>>
				<td><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></td>
				<td class="date"><?php topic_start_time(); ?></td>
				<td class="date">
					<?php if ( get_topic_start_time( 'timestamp' ) < get_topic_time( 'timestamp' ) ) { ?>
					<a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?> <?php _e( 'ago', 'bb-mystique' ); ?></a>
					<?php } else { ?> - <?php } ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php else : if ( $page ) : ?>
	<p><?php _e( 'No more topics posted.', 'bb-mystique' ); ?></p>
	<?php else : ?>
	<p><?php _e( 'No topics posted yet.', 'bb-mystique' ); ?></p>
	<?php endif; endif;?>
	
</div>

<?php profile_pages( array( 'before' => '<div class="nav">', 'after' => '</div>' ) ); ?>

<?php bb_get_footer(); ?>
