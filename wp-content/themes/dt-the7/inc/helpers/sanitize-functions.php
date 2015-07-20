<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'presscore_sanitize_enum' ) ) :

	function presscore_sanitize_enum( $val, $enum, $default_val = '' ) {
		if ( ! is_array( $enum ) ) {
			return $default_val;
		}

		return in_array( $val, $enum ) ? $val : $default_val;
	}

endif;

if ( ! function_exists( 'presscore_sanitize_explode_string' ) ) :

	function presscore_sanitize_explode_string( $val, $glue = ',' ) {
		return array_map( 'trim' , explode( $glue, $val ) );
	}

endif;

if ( ! function_exists( 'presscore_esc_implode' ) ) :

	function presscore_esc_implode( $glue, $array ) {

		if ( ! is_array( $array ) ) {
			$array = array( $array );
		}

		return esc_attr( implode( $glue, $array ) );
	}

endif;

if ( ! function_exists( 'presscore_remove_wpautop' ) ) :

	/**
	 * Inspired by wpb_js_remove_wpautop() from js_composer
	 *
	 * @since 1.0.0
	 * 
	 * @param  string  $content Some text
	 * @param  boolean $autop   Apply wpautop to $content ?
	 * @return string           Text with computed shortcodes
	 */
	function presscore_remove_wpautop( $content, $autop = false ) {
		if ( $autop ) {
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}
		return do_shortcode( shortcode_unautop( $content) );
	}

endif;
