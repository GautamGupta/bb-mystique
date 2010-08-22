<?php if ( !bb_is_topic() ) : ?>
<p id="post-form-title-container">
	<label for="topic"><?php _e( 'Title', 'bb-mystique' ); ?>
		<input name="topic" type="text" id="topic" size="50" maxlength="100"<?php bb_tabindex(); ?> />
	</label>
</p>
<?php endif; do_action( 'post_form_pre_post' ); ?>

<p id="post-form-post-container">
	<label for="post_content"><?php _e( 'Post', 'bb-mystique' ); ?>
		<textarea name="post_content" cols="50" rows="8" id="post_content"<?php bb_tabindex(); ?>></textarea>
	</label>
</p>

<?php if ( bb_is_user_logged_in() ) : /* Display Tags box to only logged in users */ ?>
<p id="post-form-tags-container">
	<label for="tags-input"><?php _e( 'Tags (comma separated)', 'bb-mystique' ); ?>
		<input id="tags-input" name="tags" type="text" size="50" maxlength="100" value="<?php bb_tag_name(); ?>"<?php bb_tabindex( array( 'set_to_value' => 9 ) ); ?> />
	</label>
</p>
<?php endif; ?>

<?php if ( bb_is_tag() || bb_is_front() ) : ?>
<p id="post-form-forum-container">
	<label for="forum-id"><?php _e( 'Forum', 'bb-mystique' ); ?>
		<?php bb_new_topic_forum_dropdown( array( 'tab' => 7 ) ); ?>
	</label>
</p>
<?php endif; ?>

<?php if ( bb_is_user_logged_in() && function_exists( 'bb_is_subscriptions_active' ) && function_exists( 'bb_user_subscribe_checkbox' ) && bb_is_subscriptions_active() ) : ?>
<p id="post-form-subscription-container" class="right">
	<?php bb_user_subscribe_checkbox( 'tab=8' ); ?>
</p>
<?php endif; ?>

<p id="post-form-submit-container" class="submit left">
	<input type="submit" id="postformsub" name="Submit" value="<?php esc_attr_e( 'Send Post &raquo;', 'bb-mystique' ); ?>"<?php bb_tabindex(); ?> />
</p>

<p id="post-form-allowed-container" class="allowed clear"><?php printf( __( 'Allowed markup: %s.', 'bb-mystique' ), '<code>' . get_allowed_markup() . '</code>' ); ?><br /><?php _e( 'You can also put code in between backtick ( <code>`</code> ) characters.', 'bb-mystique' ); ?></p>
