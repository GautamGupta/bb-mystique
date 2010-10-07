<?php bb_get_header(); ?>

<h2 id="userlogin" role="main"><?php !empty( $user_login ) ? _e( 'Log in failed', 'bb-mystique' ) : _e( 'Log in', 'bb-mystique' ) ; ?></h2>

<form method="post" action="<?php bb_uri( 'bb-login.php', null, BB_URI_CONTEXT_FORM_ACTION + BB_URI_CONTEXT_BB_USER_FORMS ); ?>">
	<fieldset>
		<table>
<?php
	$user_login_error	= $bb_login_error->get_error_message( 'user_login' );
	$user_email_error	= $bb_login_error->get_error_message( 'user_email' );
	$user_password_error	= $bb_login_error->get_error_message( 'password' );
?>
			<tr valign="top" class="form-field <?php if ( $user_login_error || $user_email_error ) echo ' form-invalid error'; ?>">
				<th scope="row">
					<label for="user_login"><?php _e( 'Username', 'bb-mystique' ); ?></label>
					<?php if ( $user_login_error ) echo "<em>$user_login_error</em>"; ?>
					<?php if ( $user_email_error ) echo "<em>$user_email_error</em>"; ?>
				</th>
				<td>
					<input name="user_login" id="user_login" type="text" value="<?php echo $user_login; ?>"<?php bb_tabindex(); ?> />
				</td>
			</tr>
			<tr valign="top" class="form-field <?php if ( $user_password_error ) echo 'form-invalid error'; ?>">
				<th scope="row">
					<label for="password"><?php _e( 'Password', 'bb-mystique' ); ?></label>
					<?php if ( $user_password_error ) echo "<em>$user_password_error</em>"; ?>
				</th>
				<td>
					<input name="password" id="password" type="password"<?php bb_tabindex(); ?> />
				</td>
			</tr>

			<tr valign="top" class="form-field">
				<th scope="row"><label for="remember"><?php _e( 'Remember me', 'bb-mystique' ); ?></label></th>
				<td><input name="rememberme" type="checkbox" id="remember" value="1"<?php echo $remember_checked; bb_tabindex(); ?> /></td>
			</tr>
			<tr>
				<th scope="row">&nbsp;</th>
				<td>
					<input name="re" type="hidden" value="<?php echo $redirect_to; ?>" />
					<input type="submit" value="<?php echo esc_attr( !empty( $user_login ) ? __( 'Try Again &raquo;', 'bb-mystique' ): __( 'Log in &raquo;', 'bb-mystique' ) ); ?>"<?php bb_tabindex(); ?> />
					<?php wp_referer_field(); ?>
				</td>
			</tr>
		</table>
	</fieldset>
</form>

<h2 id="passwordrecovery"><?php _e( 'Password Recovery', 'bb-mystique' ); ?></h2>
<form method="post" action="<?php bb_uri( 'bb-reset-password.php', null, BB_URI_CONTEXT_FORM_ACTION + BB_URI_CONTEXT_BB_USER_FORMS ); ?>">
<fieldset>
	<p><?php _e( 'To recover your password, enter your information below.', 'bb-mystique' ); ?></p>
	<table>
		<tr valign="top" class="form-field">
			<th scope="row">
				<label for="user_login_reset_password"><?php _e( 'Username', 'bb-mystique' ); ?></label>
			</th>
			<td>
				<input name="user_login" id="user_login_reset_password" type="text" value="<?php echo $user_login; ?>"<?php bb_tabindex(); ?> />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"></th>
			<td>
				<input type="submit" value="<?php esc_attr_e( 'Recover Password &raquo;', 'bb-mystique' ); ?>"<?php bb_tabindex(); ?> />
			</td>
		</tr>
	</table>
</fieldset>
</form>

<?php bb_get_footer(); ?>
