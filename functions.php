<?php
/* bb Mystique Theme */

bb_load_theme_textdomain( 'bb-mystique' );

define( 'THEME_VERSION', '1.0' );

// core files, required
require_once( 'lib/core.php' );
require_once( 'lib/settings.php' );

mystique_verify_options();

// optional
//require_once( 'lib/widgets.php' );

//if ( bb_is_admin() ) require_once( 'admin/theme-settings.php' );

/* JS/CSS */
add_action( 'bb_head', 'mystique_load_stylesheets', 1 );
add_action( 'wp_print_scripts', 'mystique_load_scripts', 1 );

/* The below actions are removed because we add our own checkbox (check post-form.php and edit-form.php) */
remove_action( 'post_form', 'bb_user_subscribe_checkbox' );
remove_action( 'edit_form', 'bb_user_subscribe_checkbox' );
