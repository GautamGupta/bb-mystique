<?php if ( $topic_title ) : ?>
<p role="main">
	<label for="topic"><?php _e( 'Topic:', 'bb-mystique' ); ?><br />
		<input name="topic" type="text" id="topic" size="50" maxlength="100"<?php bb_tabindex(); ?> value="<?php echo esc_attr( get_topic_title() ); ?>" />
	</label>
</p>
<?php endif; do_action( 'edit_form_pre_post' ); ?>

<p>
	<label for="post_content"><?php _e( 'Post:', 'bb-mystique' ); ?><br />
		<textarea name="post_content" cols="50" rows="8"<?php bb_tabindex( array( 'set_to_value' => 4 ) ); ?> id="post_content"><?php echo apply_filters( 'edit_text', get_post_text() ); ?></textarea>
	</label>
</p>

<?php if ( bb_is_user_logged_in() && function_exists( 'bb_is_subscriptions_active' ) && function_exists( 'bb_user_subscribe_checkbox' ) && bb_is_subscriptions_active() ) : ?>
<p id="post-form-subscription-container" class="right">
	<?php bb_user_subscribe_checkbox( 'tab=3' ); ?>
</p>
<?php endif; ?>

<p class="submit left">
	<input type="submit" name="Submit" value="<?php esc_attr_e( 'Edit Post &raquo;', 'bb-mystique' ); ?>"<?php bb_tabindex(); ?> />
	<input type="hidden" name="post_id" value="<?php post_id(); ?>" />
	<input type="hidden" name="topic_id" value="<?php topic_id(); ?>" />
</p>

<p id="post-form-allowed-container" class="allowed clear"><?php printf( __( 'Allowed markup: %s.', 'bb-mystique' ), '<code>' . get_allowed_markup() . '</code>' ); ?><br /><?php _e( 'You can also put code in between backtick ( <code>`</code> ) characters.' ); ?></p>