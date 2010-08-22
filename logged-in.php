<div class="login logged_in clearfix">
	<?php search_form(); ?>
	<?php printf( __( 'Welcome, %s', 'bb-mystique' ), bb_get_profile_link( bb_get_current_user_info( 'name' ) ) ); ?>
	<?php bb_admin_link( 'before= | ' );?>
	| <?php bb_logout_link(); ?>
</div>
