<?php
$_head_profile_attr = '';
if ( bb_is_profile() ) {
	global $self;
	if ( !$self ) $_head_profile_attr = ' profile="http://www.w3.org/2006/03/hcard"';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php bb_language_attributes( '1.1' ); ?>>

<head<?php echo $_head_profile_attr; ?>>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php bb_title(); ?></title>

<?php bb_feed_head(); ?>

<?php bb_head(); ?>

</head>
<body id="<?php bb_location(); ?>" class="col-1 <?php bb_print_mystique_option( 'page_width' ); ?>">
	<div id="page">
		<div class="page-content header-wrapper">
			<div id="header" class="bubbleTrigger">
				<?php do_action( 'bb_mystique_header_start' ); ?>
				<div id="site-title" class="clear-block">
					<?php bb_mystique_logo(); ?>
				        <?php if( bb_get_option( 'description' ) ): ?><p class="headline"><?php bb_option( 'description' ); ?></p><?php endif; ?>
					<?php do_action( 'bb_mystique_header' ); ?>
				</div>
				<div class="shadow-left">
					<div class="shadow-right clear-block">
						<p class="nav-extra">
							<?php if ( $twitUser = bb_get_mystique_option( 'twitter_id' ) ) : ?>
							<a title="<?php _e( 'Follow me on Twitter', 'bb-mystique' ); ?>" class="nav-extra twitter" href="http://twitter.com/<?php echo $twitUser; ?>" style="margin-top: 0px;"><span><?php _e( 'Follow me on Twitter', 'bb-mystique' ); ?></span></a>
							<?php endif; unset( $twitUser ); ?>
							<a title="<?php _e( 'RSS Feeds', 'bb-mystique' ); ?>" class="nav-extra rss" href="<?php echo bb_get_topics_rss_link( BB_URI_CONTEXT_LINK_ALTERNATE_HREF + BB_URI_CONTEXT_BB_FEED ); ?>"><span><?php _e( 'RSS Feeds', 'bb-mystique' ); ?></span></a>
						</p>
						<ul class="navigation clear-block sf-js-enabled">
							<?php $activeClass = bb_is_front() ? 'active ' : ''; ?>
							<li class="<?php echo $activeClass; ?>home"><a title="You are Home" href="<?php bb_uri(); ?>" class="home <?php echo $activeClass; ?>fadeThis"><span class="title">Home</span><span class="pointer"></span><span class="hover" style="opacity: 0;"></span></a></li>
							<!-- <li class="page"><a title="Other" href="<?php bb_uri(); ?>" class="fadeThis"><span class="title">Your URLs here</span><span class="pointer"></span><span class="hover" style="opacity: 0;"></span></a></li> -->
						</ul>
					</div>
				</div>
				<?php do_action( 'bb_mystique_header_end' ); ?>
			</div>
		</div>

		<!-- left+right bottom shadow -->
		<div class="shadow-left page-content main-wrapper">
			<div class="shadow-right">
				<?php do_action( 'bb_mystique_before_main' ); ?>

				<!-- main content: primary -->
				<div id="main">
					<div id="main-inside" class="clear-block">
						<!-- primary content -->
						<div id="primary-content">
							<div class="blocks">
								<?php do_action( 'bb_mystique_before_primary' ); ?>
								<?php if ( !in_array( bb_get_location(), array( 'login-page', 'register-page' ) ) ) login_form(); ?>
								<?php bb_auto_crumbs(); ?>
								<?php if ( bb_is_profile() ) profile_menu(); ?>
