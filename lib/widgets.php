<?php

/* bb Mystique */

function display_twitter_data( $id, $twituser, $twitcount, $twitdata = false ) {
	if( !$twitdata && false === ( $twitdata = bb_get_transient( 'mystique_twitter_' . $id ) ) ) {
		$response = wp_remote_retrieve_body( wp_remote_get( 'http://twitter.com/users/show/' . $twituser . '.json' ) );
		if ( $response ) $userdata = json_decode( $response, true );
		
		$response = wp_remote_retrieve_body( wp_remote_get( 'http://twitter.com/statuses/user_timeline/' . $twituser . '.json' ) );
		if ( $response ) $tweets = json_decode( $response, true );
		
		if ( $userdata && $tweets ) {
			// for php < 5 (included JSON returns object)
			$userdata = mystique_objectToArray( $userdata );
			$tweets = mystique_objectToArray( $tweets );
			
			$twitdata = array();
			
			$twitdata['user']['profile_image_url'] = $userdata['profile_image_url'];
			$twitdata['user']['name'] = $userdata['name'];
			$twitdata['user']['screen_name'] = $userdata['screen_name'];
			$twitdata['user']['followers_count'] = $userdata['followers_count'];
			$i = 0;
			foreach ( $tweets as $tweet ) {
				$twitdata['tweets'][$i]['text'] = $tweet['text'];
				$twitdata['tweets'][$i]['created_at'] = $tweet['created_at'];
				$twitdata['tweets'][$i]['id'] = $tweet['id'];
				$i++;
			}
			bb_set_transient( 'mystique_twitter_' . $id, $twitdata, 60 ); // keep the data cached 60 seconds
		}
	}

	// only show if the twitter data from the database is newer than 6 hours
	if ( is_array( $twitdata['tweets'] ) ) { ?>
	<div class="clear-block">
		<div class="avatar"><img src="<?php echo $twitdata['user']['profile_image_url']; ?>" alt="<?php echo $twitdata['user']['name']; ?>" /></div>
		<div class="info"><a href="http://twitter.com/<?php echo $twituser; ?>"><?php echo $twitdata['user']['name']; ?> </a><br /><span class="followers"> <?php printf( __( '%s followers', 'bb-mystique' ),$twitdata['user']['followers_count']); ?></span></div>
	</div>
       
	<ul>
	<?php
		$i = 0;
		foreach ( $twitdata['tweets'] as $tweet ) {
			$pattern = '/\@(\w+)/';
			$replace = '<a rel="nofollow" href="http://twitter.com/$1">@$1</a>';
			$tweet['text'] = preg_replace( $pattern, $replace, $tweet['text'] );
			$tweet['text'] = make_clickable( $tweet['text'] );
			
			// remove +XXXX
			$tweettime = substr_replace( $tweet['created_at'], '', strpos( $tweet['created_at'], "+" ), 5 );
			
			$link = 'http://twitter.com/' . $twitdata['user']['screen_name'] . '/statuses/' . $tweet['id'];
			echo '<li><span class="entry">' . $tweet['text'] .'<a class="date" href="' . $link . '" rel="nofollow">' . mystique_timeSince( abs( strtotime( $tweettime . " GMT" ) ), time() ) . '</a></span></li>';
			$i++;
			if ( $i == $twitcount ) break;
		}
	 ?>
	</ul>
      
	<?php } else { ?>
		<p class="error"><?php _e( 'Error while retrieving tweets (Twitter down?)', 'bb-mystique' ); ?></p>
	<?php }
}

function get_twitter_data() {
	if ( $_GET['get_twitter_data'] == 1 ) {
		display_twitter_data( wp_specialchars( $_GET['widget_id'] ), wp_specialchars( $_GET['twituser'] ), wp_specialchars( $_GET['twitcount'] ) );
		die();
	}
}
add_action( 'bb_init', 'get_twitter_data' );

// twitter widget

function twitter_widget() {
	$twituser = get_mystique_option( 'twitter_id' ) ? get_mystique_option( 'twitter_id' ) : 'bbPress';
	$twitcount = '4';
	$id = 'instance-twitterwidget-3';
	$shortid = '3';
	$nonce = bb_create_nonce( 'gettwitterdata' );
	
	if ( get_mystique_option( 'jquery' ) ) {
	?>
	
		<div class="twitter-content clear-block" id="<?php echo $id; ?>">
		<?php
		if ( false === ( $twitdata = bb_get_transient( 'mystique_twitter_' . $shortid ) ) ) { ?>
	
			<script type="text/javascript">
			/* <![CDATA[ */
	      
			// init
			jQuery(document).ready(function(){
				jQuery.ajax({ // load tweets trough ajax to avoid waiting for twitter's response
					type: "GET",url: "<?php bb_uri(); ?>",data: { widget_id: '<?php echo $shortid; ?>', twituser: '<?php echo $twituser; ?>', twitcount: '<?php echo $twitcount; ?>', get_twitter_data: 1 },
					beforeSend: function() {jQuery("#<?php echo $id; ?> .loading").show('slow');},
					complete: function() { jQuery("#<?php echo $id; ?> .loading").hide('fast');},
					success: function(html) {
						jQuery("#<?php echo $id; ?>").html(html);
						jQuery("#<?php echo $id; ?>").show('slow');
					}
				});
			});
			/* ]]> */
			</script>
			<div class="loading"><?php _e( 'Loading tweets...', 'bb-mystique' ); ?></div>
	
		<?php
		} else {
			display_twitter_data( $shortid, $twituser, $twitcount, $twitdata );
		}
		?>
		</div>
	
	<?php } else { ?>
	<p class="error"><?php _e( 'jQuery is disabled and this widget needs it', 'bb-mystique' ); ?></p>
	<?php } ?>

	<?php if ( $twituser ) { ?>
	<a class="followMe" href="http://twitter.com/<?php echo $twituser; ?>"><span><?php _e( 'Follow me on Twitter!', 'bb-mystique' ); ?></span></a>
	<?php }
}

?>
