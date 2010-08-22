<?php bb_get_header(); ?>

<h2 role="main"><?php _e( 'Password Reset', 'bb-mystique' ); ?></h2>

<?php do_action( 'bb_before_password_reset_message' ); ?>

<?php if ( $error ) : ?>

<p><?php echo $error; ?></p>

<?php else : ?>

<?php switch ( $action ) : ?>
<?php case ( 'send_key' ) : ?>
<p><?php _e( 'An email has been sent to the address we have on file for you. If you don&#8217;t get anything within a few minutes, or your email has changed, you may want to get in touch with the webmaster or forum administrator here.', 'bb-mystique' ); ?></p>
<?php break; ?>

<?php case ( 'reset_password' ) : ?>
<p><?php _e( 'Your password has been reset and a new one has been mailed to you.', 'bb-mystique' ); ?></p>
<?php break; ?>

<?php default: ?>
<?php do_action( 'bb_password_reset_message', $action ); ?>
<?php break; ?>

<?php endswitch; ?>
<?php endif; ?>

<?php do_action( 'bb_after_password_reset_message' ); ?>

<?php bb_get_footer(); ?>
