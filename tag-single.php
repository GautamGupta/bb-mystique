<?php bb_get_header(); ?>

<?php do_action( 'tag_above_table' ); /* DEPRECATED, use the one in functions.php */ ?>

<?php bb_kakumei_topics_table(); ?>

<?php post_form(); ?>

<?php do_action( 'tag_below_table' ); /* DEPRECATED, use the one in functions.php */ ?>

<?php manage_tags_forms(); ?>

<?php bb_get_footer(); ?>