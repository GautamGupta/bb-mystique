		<div class="thread-head">
			<div class="avatar-box"><?php post_author_avatar_link(); ?></div>
			<div class="author">
				<span class="by"><?php post_author_link(); ?></span> - <?php post_author_title_link(); ?>
				<?php do_action( 'bb_post_threadauthor_meta', get_post_id() ); ?><br />
				<?php printf( __('Posted %s ago'), bb_get_post_time() ); ?> <a href="<?php post_anchor_link(); ?>">#</a> <?php bb_post_admin(); ?>
				<?php do_action( 'bb_post_threadpost_after_stuff', get_post_id() ); ?>
			</div>
		</div>
		<div class="thread-body clearfix">
			<?php post_text(); ?>
		</div>