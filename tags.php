<?php bb_get_header(); ?>

<p role="main"><?php _e( 'This is a collection of tags that are currently popular on the forums.', 'bb-mystique' ); ?></p>

<div id="hottags">
	<?php bb_tag_heat_map( 9, 38, 'pt', 80 ); ?>
</div>

<?php bb_get_footer(); ?>
