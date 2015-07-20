<?php

$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $alignment = $css_animation = $css = '';

extract( shortcode_atts( array(
	'title' => '',
	'image' => $image,
	'img_size' => 'thumbnail',
	'img_link_large' => false,
	'img_link' => '',
	'link' => '',
	'img_link_target' => '_self',
	'alignment' => 'left',
	'el_class' => '',
	'css_animation' => '',
	'style' => '',
	'border_color' => '',
	'css' => ''
), $atts ) );

$style = ( $style != '' ) ? $style : '';
$border_color = ( $border_color != '' ) ? ' vc_box_border_' . $border_color : '';

$img_class = $style . $border_color;
$img_id = preg_replace( '/[^\d]/', '', $image );

$el_class = $this->getExtraClass( $el_class );

$a_class = '';
$link_to = '';
if ( $img_link_large == true ) {
	$link_to = wp_get_attachment_image_src( $img_id, 'full' );
	$link_to = $link_to[0];
	$a_class = ' class="rollover rollover-zoom dt-mfp-item mfp-image dt-single-mfp-popup ' . $img_class . '"';
} else if ( strlen($link) > 0 ) {
	$link_to = $link;
	$a_class = ' class="rollover ' . $img_class . '"';
} else if ( ! empty( $img_link ) ) {
	$link_to = $img_link;
	if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) $link_to = 'http://' . $link_to;
	$a_class = ' class="rollover ' . $img_class . '"';
}
//to disable relative links uncomment this..

if ( ! empty( $a_class ) ) {
	$img_class = '';
}

$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => $img_class ) );
if ( $img == NULL ) $img['thumbnail'] = '<img class="' . $img_class . '" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; //' <small>'.__('This is image placeholder, edit your page to replace it.', LANGUAGE_ZONE).'</small>';

$img_output = ( $style == 'vc_box_shadow_3d' ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];
$image_string = ! empty( $link_to ) ? '<a' . $a_class . ' href="' . $link_to . '"' . ' target="' . $img_link_target . '"'. '>' . $img_output . '</a>' : $img_output;
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= ' ' . presscore_get_shortcode_animation_html_class( $css_animation );

$css_class .= ' vc_align_' . $alignment;

$output .= "\n\t" . '<div class="' . $css_class . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= "\n\t\t\t" . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
$output .= "\n\t\t\t" . $image_string;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_single_image' );

echo $output;