<?php bb_get_header(); ?>

<?php bb_auto_crumbs( 'force=404' ); /* Crumbs wouldn't have loaded on the previous call in header.php */ ?>

<h2 id="http404"><?php _e( 'Page not found!', 'bb-mystique' ); ?></h2>

<?php do_action( 'bb_404_before_message' ); ?>

<p><?php printf( __( 'We\'re sorry, but there is nothing at this page. You may want to go back to the <a href="%s">forums</a> or search below:', 'bb-mystique' ), bb_get_uri() ); ?></p>

<div class="left">
	<?php bb_topic_search_form( array( 'action' => bb_get_uri( 'search.php' ) ), new BB_Query_Form ); ?>
</div>

<?php do_action( 'bb_404_after_message' ); ?>

<?php bb_get_footer(); ?>
