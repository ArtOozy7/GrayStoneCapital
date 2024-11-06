<?php

/**
 * Theme functions. Initializes the Vamtam Framework.
 *
 * @package vamtam/numerique
 */

define( 'VAMTAM_ENVATO_THEME_ID', 'numerique' );

require_once get_template_directory() . '/vamtam/classes/framework.php';

new VamtamFramework( array(
	'name' => 'numerique',
	'slug' => 'numerique',
) );


// only for one page home demos
function vamtam_onepage_menu_hrefs( $atts, $item, $args ) {
	if ( 'custom' === $item->type && 0 === strpos( $atts['href'], '/#' ) ) {
		$atts['href'] = $GLOBALS['vamtam_inner_path'] . $atts['href'];
	}
	return $atts;
}

if ( ( $path = parse_url( get_home_url(), PHP_URL_PATH ) ) !== null ) {
	$GLOBALS['vamtam_inner_path'] = untrailingslashit( $path );
	add_filter( 'nav_menu_link_attributes', 'vamtam_onepage_menu_hrefs', 10, 3 );
}

remove_action( 'admin_head', 'jordy_meow_flattr', 1 );

require_once VAMTAM_DIR . 'customizer/setup.php';

require_once VAMTAM_DIR . 'customizer/preview.php';

// this filter fixes some invalid HTML generated by the third-party plugins
add_filter( 'vamtam_escaped_shortcodes', 'vamtam_shortcode_compat_fix' );
function vamtam_shortcode_compat_fix( $codes ) {
	$codes[] = 'gallery';
	$codes[] = 'fl_builder_insert_layout';
	$codes[] = 'wpforms';

	return $codes;
}

// Envato Hosted compatibility
add_filter( 'option_' . VamtamFramework::get_purchase_code_option_key(), 'vamtam_envato_hosted_license_key' );
function vamtam_envato_hosted_license_key( $value ) {
	if ( defined( 'SUBSCRIPTION_CODE' ) ) {
		return SUBSCRIPTION_CODE;
	}

	return $value;
}

if ( class_exists( 'Vamtam_Importers_E' ) && is_callable( array( 'Vamtam_Importers_E', 'set_menu_locations' ) ) ) {
	Vamtam_Importers_E::set_menu_locations();
}

// font weights for google fonts used in CSS
function vamtam_customizer_font_weights( $weights, $font ) {
	if ( 'Open Sans' === $font ) {
		$weights[] = '600';
	}

	return $weights;
}
add_filter( 'vamtam_customizer_font_weights', 'vamtam_customizer_font_weights', 10, 2 );

// build: e17c9e93448d86e31d71ee98dfe6e535082b6b0c
