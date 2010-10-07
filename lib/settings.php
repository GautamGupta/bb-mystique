<?php
/* bb Mystique */

/**
 * Default theme settings
 *
 * @return array The default options
 */
function bb_mystique_default_settings() {
	$defaults = array(
		'twitter_id' => '_GautamGupta_', // your twitter id
		'twitter_count' => '5', // number of tweets to display
		'background' => '', // background image url
		'background_color' => '000000', // background color
		'color_scheme' => 'green', // green or red or blue or grey
		'page_width' => 'fixed', // fixed or fluid
		'font_style' => 0, // check the codes in bb_mystique_font_styles function
		'logo' => '', // logo url
		'logo_size' => '', //eg 500x200 where 500 = width, 200 = height
		'user_css' => '', // custom css
		/* Don't change anything below this, for now */
		'theme_version' => BB_MYSTIQUE_THEME_VERSION,
		'jquery' => 1
		);

	$defaults = apply_filters( 'bb_mystique_default_settings', $defaults ); // check for new default setting entries from extensions
	return $defaults;
}

/**
 * Default font styles
 *
 * @return array Default font styles
 */
function bb_mystique_font_styles() {
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
		/* You can add more font styles here based on the above entries (4, 5, 6 etc...) */
	);
}

/**
 * Check if the options are present
 *
 * @uses bb_get_mystique_options
 * @uses bb_mystique_setup_options
 */
function bb_mystique_verify_options() {
	if( !$current_settings = bb_get_mystique_options() )
		bb_mystique_setup_options();
	
	do_action( 'bb_mystique_verify_options' );
}

/**
 * Setup Mystique Options
 *
 * @uses bb_mystique_remove_options
 * @uses bb_mystique_default_settings
 */
function bb_mystique_setup_options() {
	bb_mystique_remove_options();
	$default_settings = bb_mystique_default_settings();
	bb_update_option( 'bb-mystique', $default_settings );
	do_action( 'bb_mystique_setup_options' );
}

/**
 * Remove mystique options
 */
function bb_mystique_remove_options() {
	bb_delete_option( 'bb-mystique' );
	do_action( 'bb_mystique_remove_options' );
}

/**
 * Get all mystique options
 *
 * @return array All mystique options
 */
function bb_get_mystique_options() {
	$get_mystique_options = bb_mystique_default_settings();
	//$get_mystique_options = bb_get_option( 'bb-mystique' );
	return $get_mystique_options;
}

/**
 * Get a particular mystique option
 *
 * @param string $option The option to get
 * 
 * @uses bb_get_mystique_options
 *
 * @return mixed The option
 */
function bb_get_mystique_option( $option ) {
	$get_mystique_option = bb_get_mystique_options();
	return $get_mystique_option[$option];
}

/**
 * Prints a particular mystique option
 *
 * @param string $option The option to get
 * 
 * @uses bb_get_mystique_option
 */
function bb_print_mystique_option( $option ) {
	echo bb_get_mystique_option( $option );
}

/**
 * Check if a color is dark
 */
function bb_mystique_is_color_dark( $hex ) {

	// hex to rgb first
	$dec = hexdec( $hex );
	$r = 0xFF & ( $dec >> 0x10 );
	$g = 0xFF & ( $dec >> 0x8 );
	$b = 0xFF & $dec;
	
	// rgb to hsb (we only need b)
	$max = max( array( $r, $g, $b ) );
	$min = min( array( $r, $g, $b ) );
	$diff = $max - $min;
	$br = $max / 255;
	if ( $max > 0 ) $s = $diff / $max; else $s = 0;
	
	$s = round( $s * 100 );    // saturation
	$br = round( $br * 100 );  // brightness
	return ( ( $br < 66 )  || ( $s > 66 ) ? true : false );
}

/**
 * Load the styles in header
 */
function bb_mystique_load_stylesheets() {
	$mystique_options = bb_get_mystique_options();
	$font_styles = bb_mystique_font_styles();
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

/**
 * Load the scripts in header
 */
function bb_mystique_load_scripts() {
	if( bb_get_mystique_option( 'jquery' ) )
		wp_enqueue_script( 'bb-mystique', bb_get_active_theme_uri() . 'js/jquery.mystique.js', array( 'jquery' ), BB_MYSTIQUE_THEME_VERSION );
}
