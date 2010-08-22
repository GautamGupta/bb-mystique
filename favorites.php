<?php bb_get_header(); ?>

<h2 id="userlogin" role="main"><?php echo get_user_display_name( $user->ID ); ?> <small>(<?php echo get_user_name( $user->ID ); ?>)</small> <?php _e( 'favorites', 'bb-mystique' ); ?><?php if ( $topics ) printf( __( ' - %d', 'bb-mystique' ), $favorites_total ); ?></h2>

<?php do_action( 'bb_favorites_before_message' ); ?>

<p><?php _e( 'Favorites allow members to create a custom <abbr title="Really Simple Syndication">RSS</abbr> feed which pulls recent replies to the topics they specify.', 'bb-mystique' ); ?></p>

<?php if ( bb_current_user_can( 'edit_favorites_of', $user_id ) ) : ?>
<p><?php _e( 'To add topics to your list of favorites, just click the "Add to Favorites" link found on that topic&#8217;s page.', 'bb-mystique' ); ?></p>
<?php endif; ?>

<?php bb_kakumei_topics_table(); ?>

<?php if ( $topics ) : ?>

<p class="rss-link"><a href="<?php favorites_rss_link( $user_id ); ?>" class="rss-link"><?php _e( '<abbr title="Really Simple Syndication">RSS</abbr> feed for these favorites', 'bb-mystique' ); ?></a></p>

<?php else: if ( $user_id == bb_get_current_user_info( 'id' ) ) : ?>

<p><?php _e( 'You currently have no favorites.', 'bb-mystique' ); ?></p>

<?php else : ?>

<p><?php printf( __( '%s currently has no favorites.', 'bb-mystique' ), get_user_name( $user_id ) ); ?></p>

<?php endif; endif; ?>

<?php do_action( 'bb_favorites_after_message' ); ?>

<?php bb_get_footer(); ?>
