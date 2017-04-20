<?php

/**
 * The Shortcode
 */
function thedux_feature_banner_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'type' => '',
				'title' => '',
				'subtitle' => '',
				'custom_css' => '',
			), $atts 
		) 
	);
	
	$output = '
		<div class="feature-banner">
			<span class="feature-banner-label feature-label">'. htmlspecialchars_decode($title) .'</span>
			<div class="feature-banner__body feature__body">
				'. wp_get_attachment_image( $image, 'large' ) .'
			</div>
		</div>
	';
	
	return $output;
}
add_shortcode( 'caviar_feature_banner', 'thedux_feature_banner_shortcode' );

/**
 * The VC Functions
 */
function thedux_feature_banner_shortcode_vc() {
	vc_map(
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Feature Banner", 'caviar'),
			"base" => "caviar_feature_banner",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'caviar'),
					"param_name" => "image"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'caviar'),
					"param_name" => "title",
					'holder' => 'div'
				),
			)
		)
	);
}
add_action( 'vc_before_init', 'thedux_feature_banner_shortcode_vc' );