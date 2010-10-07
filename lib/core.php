<?php
/* bb Mystique */

if ( !$bb_tabindex ) {
	global $bb_tabindex;
	$bb_tabindex = 1;
}

if ( !function_exists( 'bb_tabindex' ) ) :
/**
 * Echoes tabindex and also increments it
 *
 * @param mixed $args
 * @since 1.1
 */
function bb_tabindex( $args = false ) {
	echo bb_get_tabindex( $args );
}
endif;

if ( !function_exists( 'bb_get_tab_index' ) ) :
/**
 * Returns tabindex and also increments it
 *
 * @param mixed $args
 * @since 1.1
 */
function bb_get_tabindex( $args = false ) {
	$defaults = array(
		'val'		=> false,	/* (false or int) If it is passed, then it will be echoed instead of $bb_tabindex and $bb_tabindex will also not be incremented */
		'set_to_value'	=> false	/* (false or int) If an integer is passed, $bb_tabindex is set to it */
	);
	$args = wp_parse_args( $args, $defaults );

	global $bb_tabindex;
	if ( !$bb_tabindex )
		$bb_tabindex = '1';

	$ti = $args['val'] != false ? $args['val'] : $bb_tabindex;
	$r = ' tabindex="' . $ti . '"';

	if ( $args['set_to_value'] != false )
		$bb_tabindex = (int) $args['set_to_value'];
	elseif ( !$args['val'] )
		$bb_tabindex++;

	return $r;
}
endif;

if ( !function_exists( 'bb_auto_crumbs' ) ) :
/**
 * Generate Bread Crumbs
 *
 * @since 1.1
 * @param mixed $args
 */
function bb_auto_crumbs( $args = '' ) {
	echo apply_filters( 'bb_auto_crumbs', bb_get_auto_crumbs( $args ), $args );
}
endif;

if ( !function_exists( 'bb_get_auto_crumbs' ) ) :
/**
 * Generate Bread Crumbs
 *
 * @since 1.1
 * @param mixed $args
 */
function bb_get_auto_crumbs( $args ) {
	$defaults = array(
		'class'		=> 'bbcrumb',	/* Class for <div>, can be false */
		'id'		=> false,	/* ID for <div>, can be false */
		'span_current'	=> false,	/* The class for current page, can be false if you do not want any class (not for forum) */
		'current'	=> false,	/* Override the 'current' text (not for forum) */
		'force'		=> false,	/* Some pages like 404 have to force a to generate crumbs, this might also be used by plugins */
		'separator'	=> ' &rsaquo; '
	);
	$args = wp_parse_args( $args, $defaults );

	$r		= '';
	$crumbs		= array( bb_get_uri() => bb_get_option( 'name' )  );
	$location	= !$args['force'] ? bb_get_location() : $args['force'];
	$class		= $args['class'] ? ' class="' . $args['class'] . '"' : '';
	$id		= $args['id'] ? ' id="' . $args['id'] . '"' : '';

	switch ( $location ) {
		case 'front-page': /* For new topic */
			global $forums;
			if ( !$forums && isset( $_GET['new'] ) && '1' == $_GET['new'] )
				$crumbs['current'] = __( 'Add New Topic', 'bb-mystique' );
			break;
		case 'login-page':
			$crumbs['current'] = __( 'Log in', 'bb-mystique' );
			break;
		case 'profile-base': /* Is forced */
			global $user_id, $profile_page_title;
			$crumbs[get_user_profile_link( $user_id )] = get_user_display_name( $user_id );
			$crumbs['current'] = $profile_page_title;
			break;
		case 'profile-page': /* Also for favorites and profile edit */
			global $user_id;
			$crumbs[get_user_profile_link( $user_id )] = get_user_display_name( $user_id );
			if ( $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : bb_get_path( 2 ) ) {
				if ( $tab == 'favorites' )
					$crumbs['current'] = __( 'Favorites', 'bb-mystique' );
				elseif ( $tab == 'edit' )
					$crumbs['current'] = __( 'Edit Profile', 'bb-mystique' );
			} else {
				$crumbs['current'] = __( 'Profile', 'bb-mystique' );
			}
			break;
		case 'register-page':
			$crumbs['current'] = __( 'Register', 'bb-mystique' );
			break;
		case 'search-page':
			$crumbs['current'] = __( 'Search', 'bb-mystique' );
			break;
		case 'stats-page':
			$crumbs['current'] = __( 'Statistics', 'bb-mystique' );
			break;
		case 'tag-page':
			$crumbs[bb_get_tag_page_link()] = __( 'Tags', 'bb-mystique' );
			if ( bb_is_tag() )
				$crumbs['current'] = bb_get_tag_name();
			break;
		case 'view-page':
			$crumbs['current'] = get_view_name();
			break;
		case 'topic-page':
			$crumbs['direct_return'] = bb_get_forum_bread_crumb( array( 'separator' => $args['separator'] ) );
			$crumbs['current'] = $args['separator'] . get_topic_title();
			break;
		case 'forum-page':
			$crumbs['direct_return'] = bb_get_forum_bread_crumb( array( 'separator' => $args['separator'] ) );
			break;
		case 'topic-edit-page':
			$crumbs['current'] = __( 'Edit Post', 'bb-mystique' );
			break;
		case '404': /* Is forced */
			$crumbs['current'] = __( 'Page not found!', 'bb-mystique' );
			break;
		default:
			$crumbs = apply_filters( 'bb_get_auto_crumbs_location', $crumbs, $location, $args );
			break;
	}

	if ( count( $crumbs ) > 1 ) {
		$r .= '<div ' . $class . $id . '">';
		foreach ( $crumbs as $url => $text ) {
			switch ( $url ) {
				case 'direct_return': /* No &raquo, span or link, direct return */
					$r .= $text;
					break;
				case 'current': /* Checks if there is text for current, if not uses the one given in above switch. Also checks if span_current class is given or not */
					if ( !empty( $args['current'] ) )
						$text = $args['current'];
					$r .= ( !$args['span_current'] ) ? $text : '<span class="' . $args['current'] . '">' . $text . '</span>';
					break;
				case null: /* If no url, then just return with a &raquo; */
					$r .= $text . ' &raquo; ';
					break;
				default:
					$sep = in_array( $location, array( 'forum-page', 'topic-page' ) ) ? '' : $args['separator']; /* Separator is added in bb_get_form_bread_crumb too */
					$r .= '<a href="' . $url . '">' . $text . '</a>' . $sep;
					break;
			}
		}
		$r .= '</div>';
	}

	return apply_filters( 'bb_get_auto_crumbs', $r, $args );
}
endif;

/**
 * Displays feed links for current page - Normally 1 or 2
 */
function bb_mystique_feed_box() {

	$feeds = array();

	switch ( bb_get_location() ) {
		case 'profile-page':
			if ( $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : bb_get_path( 2 ) )
				if ( $tab != 'favorites' )
					break;

			$feeds[] = array(
				'title' => __( 'these favorites', 'bb-mystique' ),
				'href'  => get_favorites_rss_link( 0, BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
			);
			break;

		case 'topic-page':
			$feeds[] = array(
				'title' => __( 'posts in this topic', 'bb-mystique' ),
				'href'  => get_topic_rss_link( 0, BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
			);
			break;

		case 'tag-page':
			if ( bb_is_tag() ) {
				$feeds[] = array(
					'title' => sprintf( __( 'recent posts tagged <em>%s</em>', 'bb-mystique' ), bb_get_tag_name() ),
					'href'  => bb_get_tag_posts_rss_link( 0, BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
				);
				$feeds[] = array(
					'title' => sprintf( __( 'recent topics tagged <em>%s</em>', 'bb-mystique' ), bb_get_tag_name() ),
					'href'  => bb_get_tag_topics_rss_link( 0, BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
				);
			}
			break;

		case 'forum-page':
			$feeds[] = array(
				'title' => sprintf( __( 'recent posts in <em>%s</em>', 'bb-mystique' ), get_forum_name() ),
				'href'  => bb_get_forum_posts_rss_link( 0, BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
			);
			$feeds[] = array(
				'title' => sprintf( __( 'recent topics in <em>%s</em>', 'bb-mystique' ), get_forum_name() ),
				'href'  => bb_get_forum_topics_rss_link( 0, BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
			);
			break;

		case 'front-page':
			$feeds[] = array(
				'title' => __( 'all recent posts', 'bb-mystique' ),
				'href'  => bb_get_posts_rss_link( BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
			);
			$feeds[] = array(
				'title' => __( 'all recent topics', 'bb-mystique' ),
				'href'  => bb_get_topics_rss_link( BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
			);
			break;

		case 'view-page':
			global $bb_views, $view;
			if ( $bb_views[$view]['feed'] ) {
				$feeds[] = array(
					'title' => sprintf( __( 'topics in the view <em>%s</em>', 'bb-mystique' ), get_view_name() ),
					'href'  => bb_get_view_rss_link( null, BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED )
				);
			}
			break;
	}

	if ( count( $feeds ) ) {
		?>
		<p class="rss-link">
		<?php
		foreach ( $feeds as $feed )
			echo '<a class="rss-link" href="' . $feed['href'] . '">' . sprintf( __( '<abbr title="Really Simple Syndication">RSS</abbr> feed for %s', 'bb-mystique' ), $feed['title'] ) . '</a><br />' . "\n";
		?>
		</p>
		<?php
	}

}

if ( !function_exists( 'bb_kakumei_topics_table' ) ) :
/**
 * Kakumei Topics Table
 *
 * Theme authors are suggested to use the same function (or include this file)
 * in their themes and also include do_action functions for the plugins to
 * modify any bit of it
 *
 * This is not included in the core because every theme has a different way of
 * showing the content (some even don't use tables).
 *
 * @since 1.1
 *
 * @param string $type Optional. The type of the page, eg. forum-page, etc.
 *
 * @return void
 */
function bb_kakumei_topics_table( $type = '' ) {
	if ( bb_is_forum() || bb_is_view() ) { /* It is stickies for forum and view */
		global $stickies;
		$super_stickies = $stickies;
	}
	global $topics, $super_stickies, $user;

	if ( ( count( $topics ) + count( $super_stickies ) ) == 0 ) return;

	if ( !$type ) {
		switch ( bb_get_location() ) {
			case 'forum-page':
				$type = 'forum';
				break;
			case 'profile-page': /* For favorites */
				if ( $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : bb_get_path( 2 ) )
					if ( $tab == 'favorites' )
						$type = 'favorites';
				break;
			case 'favorites-page':
				$type = 'favorites';
				break;
			case 'tag-page':
				$type = 'tag';
				break;
			case 'view-page':
				$type = 'view';
				break;
			case 'front-page':
			default:
				$type = 'front';
				break;
		}
	}

	do_action( 'bb_topics_above_table_before_heading', $type, $topics, $super_stickies );
	$heading = $type == 'front' ? __( 'Latest Discussions', 'bb-mystique' ) : __( 'Topics', 'bb-mystique' );
	?>

	<h2><?php echo $heading; ?><span class="new-topic"> &#8212; <?php bb_new_topic_link( array( 'text' => __( 'start new', 'bb-mystique' ) ) ); ?></span></h2>
	<?php do_action( 'bb_topics_above_table', $type, $topics, $super_stickies ); ?>
	<table id="latest" cellspacing="0">
		<thead>
			<tr>
				<th><?php _e( 'Topic', 'bb-mystique' ); ?></th>
				<th><?php _e( 'Posts', 'bb-mystique' ); ?></th>
				<th><?php _e( 'Voices', 'bb-mystique' ); ?></th>
				<th><?php _e( 'Last Poster', 'bb-mystique' ); ?></th>
				<th><?php _e( 'Freshness', 'bb-mystique' ); ?></th>
				<?php if ( $type == 'favorites' && bb_current_user_can( 'edit_favorites_of', $user->ID ) ) : ?>
				<th><?php _e( 'Remove', 'bb-mystique' ); ?></th>
				<?php
				endif;
				do_action( 'bb_topics_thead', $type, $topics, $super_stickies );
				?>
			</tr>
		</thead>
		<tbody>
	<?php
	if ( $super_stickies ) :
		do_action( 'bb_topics_before_stickies', $type, $topics, $super_stickies );
		foreach ( $super_stickies as $topicc ) :
			global $topic; $topic = $topicc; /* Bad hack */
			if ( !$topic ) continue;
	?>
			<tr<?php topic_class(); ?>>
				<td class="w40"><?php bb_topic_labels(); ?> <big><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></big><?php topic_page_links(); ?></td>
				<td class="num"><?php topic_posts(); ?></td>
				<td class="num"><?php bb_topic_voices(); ?></td>
				<td class="num"><?php topic_last_poster(); ?></td>
				<td class="num"><a href="<?php topic_last_post_link(); ?>" title="<?php topic_time( array( 'format' => 'datetime' ) ); ?>"><?php topic_time(); ?></a></td>
				<?php if ( $type == 'favorites' && bb_current_user_can( 'edit_favorites_of', $user->ID ) ) : ?>
				<td class="num">[<?php user_favorites_link( '', array( 'mid' => '&times;' ), $user->ID ); ?>]</td>
				<?php
				endif;
				do_action( 'bb_topics_sticky_td', $topic, $type, $topics, $super_stickies );
				?>
			</tr>
	<?php
		endforeach;
		do_action( 'bb_topics_after_stickies', $type, $topics, $super_stickies );
	endif; // $super_stickies

	do_action( 'bb_topics_after_stickies_before_topics', $type, $topics, $super_stickies );

	if ( $topics ) :
		do_action( 'bb_topics_before_topics', $type, $topics, $super_stickies );
		foreach ( $topics as $topicc ) :
			global $topic; $topic = $topicc; /* Bad hack */
			if ( !$topic ) continue;
	?>
			<tr<?php topic_class(); ?>>
				<td><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a><?php topic_page_links(); ?></td>
				<td class="num"><?php topic_posts(); ?></td>
				<td class="num"><?php bb_topic_voices(); ?></td>
				<td class="num"><?php topic_last_poster(); ?></td>
				<td class="num"><a href="<?php topic_last_post_link(); ?>" title="<?php topic_time( array( 'format' => 'datetime' ) ); ?>"><?php topic_time(); ?></a></td>
				<?php if ( $type == 'favorites' && bb_current_user_can( 'edit_favorites_of', $user->ID ) ) : ?>
				<td class="num">[<?php user_favorites_link( '', array( 'mid' => '&times;' ), $user->ID ); ?>]</td>
				<?php
				endif;
				do_action( 'bb_topics_topic_td', $topic, $type, $topics, $super_stickies );
				?>
			</tr>
	<?php
		endforeach;
		do_action( 'bb_topics_after_topics', $type, $topics, $super_stickies );
	endif;
	?>
		</tbody>
	</table>
	<?php
	do_action( 'bb_topics_after_topics', $type, $topics, $super_stickies );

	switch ( $type ) {
		case 'tag':
			tag_pages( array( 'before' => '<div class="nav">', 'after' => '</div>' ) );
			break;
		case 'forum':
			forum_pages( array( 'before' => '<div class="nav">', 'after' => '</div>' ) );
			break;
		case 'favorites':
			favorites_pages( array( 'before' => '<div class="nav">', 'after' => '</div>' ) );
			break;
		case 'view':
			echo '<div class="nav">'; view_pages(); echo '</div>';
			break;
		case 'front':
		default:
			bb_latest_topics_pages( array( 'before' => '<div class="nav">', 'after' => '</div>' ) );
			break;
	}

	bb_mystique_feed_box();

	do_action( 'bb_topics_after_topics_after_pages', $type, $topics, $super_stickies );
}
endif;

/**
 * Display the logo if present, else display the forum name
 */
function bb_mystique_logo() {
	$logo = bb_get_mystique_option( 'logo' );
	$size = bb_get_mystique_option( 'logo_size' );
	if ( $size ) $size = 'width="' . substr( $size, 0, strpos( $size, "x" ) ) . '" height="' . substr( $size, strpos( $size, 'x' ) + 1 ) . '"';

	$sitename = bb_get_option( 'name' );
	$siteurl = bb_get_uri();
	$tag = bb_is_front() ? 'h1' : 'div';

	$output = '<' . $tag.' id="logo">';

	if ( $logo ) // logo image?
		$output .= '<a href="' . $siteurl . '"><img src="' . $logo . '" title="' . $sitename . '" ' . $size . ' alt="' . $sitename . '" /></a>';
	else
		$output .= '<a href="' . $siteurl . '">' . $sitename . '</a>';

	$output .= '</' . $tag.'>';

	echo apply_filters( 'bb_mystique_logo', $output );
}

if ( !function_exists( 'mystique_objectToArray' ) ) :
function mystique_objectToArray( $object ) {
	if ( !is_object( $object ) && !is_array( $object ) ) return $object;
	if ( is_object( $object ) ) $object = get_object_vars( $object );
	return array_map( 'mystique_objectToArray', $object );
}
endif;

/**
 * Display tweets of the user
 */
function bb_mystique_twitter_widget() {
	$twituser = bb_get_mystique_option( 'twitter_id' );
	$twitcount = bb_get_mystique_option( 'twitter_count' );
	$id = 'twitterwidget-3';
	?>
<script src="http://twitterjs.googlecode.com/svn/trunk/src/twitter.min.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
getTwitters('tweet', {
	id: '<?php echo $twituser; ?>',
	count: <?php echo $twitcount; ?>,
	enableLinks: true,
	ignoreReplies: true,
	clearContents: true,
	template: '"%text%" <a href="http://twitter.com/%user_screen_name%/statuses/%id%/">%time%</a>'
});
</script>
<div id="tweet">
	<div class="loading"><?php _e( 'Loading tweets...', 'bb-mystique' ); ?></div>
</div>
<?php
	if ( $twituser ): ?>
<a class="followMe" href="http://twitter.com/<?php echo $twituser; ?>"><span><?php _e( 'Follow me on Twitter!', 'bb-mystique' ); ?></span></a>
	<?php endif;
}

/*
function bb_mystique_shareThis() {
	$bb_post = bb_get_first_post();
	$content = $bb_post->post_content;
?>
	<!-- socialize -->
	<div class="shareThis clear-block">
		<a href="#" class="control share"><?php _e("Share this post!","mystique"); ?></a>
		<ul class="bubble">
			<li><a href="http://twitter.com/home?status=<?php bb_topic_title(); ?>+-+<?php echo mystique_getTinyUrl( bb_topic_link() ); ?>" class="twitter" title="Tweet This!"><span>Twitter</span></a></li>
			<li><a href="http://digg.com/submit?phase=2&amp;url=<?php bb_topic_link(); ?>&amp;title=<?php bb_topic_title(); ?>" class="digg" title="Digg this!"><span>Digg</span></a></li>
			<li><a href="http://www.facebook.com/share.php?u=<?php bb_topic_link(); ?>&amp;t=<?php bb_topic_title(); ?>" class="facebook" title="Share this on Facebook"><span>Facebook</span></a></li>
			<li><a href="http://del.icio.us/post?url=<?php bb_topic_link(); ?>&amp;title=<?php bb_topic_title(); ?>" class="delicious" title="Share this on del.icio.us"><span>Delicious</span></a></li>
			<li><a href="http://www.stumbleupon.com/submit?url=<?php bb_topic_link(); ?>&amp;title=<?php bb_topic_title(); ?>" class="stumbleupon" title="Stumbled upon something good? Share it on StumbleUpon"><span>StumbleUpon</span></a></li>
			<li><a href="http://www.google.com/bookmarks/mark?op=add&amp;bkmk=<?php bb_topic_link(); ?>&amp;title=<?php bb_topic_title(); ?>" class="google" title="Add this to Google Bookmarks"><span>Google Bookmarks</span></a></li>
			<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php bb_topic_link(); ?>&amp;title=<?php bb_topic_title(); ?>&amp;summary=<?php echo strip_tags( $content ); ?>&amp;source=<?php bb_option( 'name' ); ?>" class="linkedin" title="Share this on Linkedin"><span>LinkedIn</span></a></li>
			<li><a href="http://buzz.yahoo.com/buzz?targetUrl=<?php bb_topic_link(); ?>&amp;headline=<?php bb_topic_title(); ?>&amp;summary=<?php echo strip_tags( $content ); ?>" class="yahoo" title="Buzz up!"><span>Yahoo Bookmarks</span></a></li>
			<li><a href="http://technorati.com/faves?add=<?php bb_topic_link(); ?>" class="technorati" title="Share this on Technorati"><span>Technorati Favorites</span></a></li>
		</ul>
	</div>
	<!-- /socialize -->
<?php
}
*/
