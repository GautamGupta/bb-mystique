<?php bb_get_header(); ?>

<h2 id="register" role="main"><?php _e( 'Great!', 'bb-mystique' ); ?></h2>

<p><?php printf( __( 'Your registration as <strong>%1$s</strong> was successful. Within a few minutes you should receive an email with your password. You may now <a href="%2$s">go back</a> to the forums.', 'bb-mystique' ), $user_login, bb_get_uri() ); ?></p>

<?php bb_get_footer(); ?>
