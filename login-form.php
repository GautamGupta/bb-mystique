<fieldset class="login">
	<?php search_form(); ?>
	<form method="post" action="<?php bb_uri( 'bb-login.php', null, BB_URI_CONTEXT_FORM_ACTION + BB_URI_CONTEXT_BB_USER_FORMS ); ?>">
		<p>
		<?php
		printf(
			__( '<a href="%1$s">Register</a> or log in - <a href="%2$s">lost password?</a>', 'bb-mystique' ),
			bb_get_uri( 'register.php', null, BB_URI_CONTEXT_A_HREF + BB_URI_CONTEXT_BB_USER_FORMS ),
			bb_get_uri( 'bb-login.php', array( 'action' => 'lostpassword' ), BB_URI_CONTEXT_A_HREF + BB_URI_CONTEXT_BB_USER_FORMS )
		);
		?>
		</p>
		
		<p>
			<label>
				<?php _e( 'Username:', 'bb-mystique', 'bb-mystique' ); ?>
				<input name="log" id="quick_user_login" size="13" maxlength="40" value="" type="text"<?php bb_tabindex(); ?>>
			</label>
			
			<label>
				<?php _e( 'Password:', 'bb-mystique', 'bb-mystique' ); ?>
				<input name="pwd" id="quick_password" size="13" maxlength="40" type="password"<?php bb_tabindex(); ?>>
			</label>
			
			<span class="remember">
				<label>
					<input name="rememberme" type="checkbox" id="quick_remember" value="1" title="<?php _e( 'Remember me', 'bb-mystique', 'bb-mystique' ); ?>"<?php bb_tabindex( array( 'set_to_value' => 5 ) ); ?><?php echo $remember_checked; ?> />
				</label>
			</span>
			
			<input name="redirect_to" type="hidden" value="<?php echo $re; ?>" />
			<?php wp_referer_field(); ?>
			
			<input type="submit" name="Submit" class="submit" value="<?php esc_attr_e( 'Log in &raquo;', 'bb-mystique' ); ?>"<?php bb_tabindex( array( 'val' => 4, 'set_to_value' => 3 ) ); ?> />
		</p>
	</form>
</fieldset>
