<?php
/* bb Mystique */

// default theme settings
function mystique_default_settings() {
	$defaults = array(
		'theme_version' => THEME_VERSION,
		'page_width' => 'fixed',
		'color_scheme' => 'green',
		'font_style' => 0,
		//'footer_content' => '[credit] <br /> [rss] [xhtml] [top]',
		//'seo' => 1,
		'jquery' => 1,
		//'logo' => '',
		//'logo_size' => '',
		'background' => '',
		'background_color' => '000000',
		//'functions' => '<?php' . str_repeat( PHP_EOL, 3 ),
		'remove_settings' => 0,
		'twitter_id' => '_GautamGupta_'
		);

	$defaults = apply_filters( 'mystique_default_settings', $defaults ); // check for new default setting entries from extensions
	return $defaults;
}

function font_styles() {
	// default font styles
	return array(
		0 => array(
				'code' => '"Segoe UI",Calibri,"Myriad Pro",Myriad,"Trebuchet MS",Helvetica,Arial,sans-serif',
				'desc' => 'Segoe UI (Windows Vista/7)'
			),
		1 => array(
				'code' => '"Helvetica Neue",Helvetica,Arial,Geneva,"MS Sans Serif",sans-serif',
				'desc' => 'Helvetica/Arial'
			),
		2 => array(
				'code' => 'Georgia,"Nimbus Roman No9 L",serif',
				'desc' => 'Georgia (sans serif)'
			),
		3 => array(
				'code' => '"Lucida Grande","Lucida Sans","Lucida Sans Unicode","Helvetica Neue",Helvetica,Arial,Verdana,sans-serif',
				'desc' => 'Lucida Grande/Sans (Mac/Windows)'
			)
		// you can add more font styles here based on the above entries (4, 5, 6 etc...)
	);
}

function mystique_verify_options() {
	if( !$current_settings = bb_get_option( 'bb-mystique' ) )
		mystique_setup_options();
	
	do_action( 'mystique_verify_options' );
}

function mystique_setup_options() {
	mystique_remove_options();
	$default_settings = mystique_default_settings();
	bb_update_option( 'bb-mystique', $default_settings );
	do_action( 'mystique_setup_options' );
}

function mystique_remove_options() {
	bb_delete_option( 'bb-mystique' );
	do_action( 'mystique_remove_options' );
}

function get_mystique_option( $option ) {
	$get_mystique_options = bb_get_option( 'bb-mystique' );
	return $get_mystique_options[$option];
}

function print_mystique_option( $option ) {
	echo get_mystique_option( $option );
}

function mystique_is_color_dark( $hex ) {

	// hex to rgb first
	$dec = hexdec($hex);
	$r = 0xFF & ($dec >> 0x10);
	$g = 0xFF & ($dec >> 0x8);
	$b = 0xFF & $dec;
	
	// rgb to hsb (we only need b)
	$max = max(array($r, $g, $b));
	$min = min(array($r, $g, $b));
	$diff = $max - $min;
	$br = $max / 255;
	if ($max > 0) $s = $diff / $max; else $s = 0;
	
	$s = round($s * 100);    // saturation
	$br = round($br * 100);  // brightness
	return (($br < 66)  || ($s > 66) ? true : false);
}

function mystique_load_stylesheets() {
	$mystique_options = bb_get_option( 'bb-mystique' );
	$font_styles = font_styles();
	/*
	$w = $mystique_options['page_width'];
	$unit = $w == 'fluid' ? '%' : 'px';
	$gs = $w == 'fluid' ? '100' : '940';
	*/
	?>
	<style type="text/css">
		@import "<?php bb_stylesheet_uri(); ?>";
		@import "<?php bb_active_theme_uri(); ?>color-<?php echo $mystique_options['color_scheme']; ?>.css";;
		<?php
			if ( in_array( $mystique_options['font_style'], array_keys( $font_styles ) ) )
				echo '*{font-family:' . $font_styles[$mystique_options['font_style']]['code'] . ';}';
			
			if ( $mystique_options['background'] )
				echo '#page{background-image:none;}body{background-image:url("' . $mystique_options['background'] . '");background-repeat:no-repeat;background-position:center top;}';
			if ( ( $mystique_options['background_color'] ) && ( strpos( $mystique_options['background_color'], '000000' ) === false ) ) {
				echo 'body{background-color:#' . $mystique_options['background_color'] . ';}';
				if ( !$mystique_options['background'] )
					echo 'body,#page{background-image:none;}';
			}
			if ( $mystique_options['user_css'] )
				echo $mystique_options['user_css'];
		?>
	</style>
	<?php if ( 'rtl' == bb_get_option( 'text_direction' ) ) : ?>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri( 'rtl' ); ?>" type="text/css" />
	<?php endif; ?>
	<!--[if lte IE 6]><link media="screen" rel="stylesheet" href="<?php bb_active_theme_uri(); ?>ie6.css" type="text/css" /><![endif]-->
	<!--[if IE 7]><link media="screen" rel="stylesheet" href="<?php bb_active_theme_uri(); ?>ie7.css" type="text/css" /><![endif]-->
	<?php
}

function mystique_load_scripts() {
	if( get_mystique_option( 'jquery' ) )
		wp_enqueue_script( 'bb-mystique', bb_get_active_theme_uri() . 'js/jquery.mystique.js', array( 'jquery' ), THEME_VERSION );
}
