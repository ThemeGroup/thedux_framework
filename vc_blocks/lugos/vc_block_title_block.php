<?php 

/**
 * The Shortcode
 */
function thedux_block_title_shortcode ( $atts ) {
	extract(
		shortcode_atts( 
			array(
				'type' => '',
				'title' => '',
				'subtitle' => '',
			), $atts 
		)
	);
	
	$output = '<div class="lugos-block-title '.$type.'"><h4>'. htmlspecialchars_decode($title) .'</h4></div>';
	
	return $output;
}
add_shortcode( 'lugos_block_title', 'thedux_block_title_shortcode' );

/**
 * The VC Functions
 */
function thedux_block_title_shortcode_vc(){
	vc_map(
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Block Title", 'lugos'),
			"base" => "lugos_block_title",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'lugos'),
					"param_name" => "type",
					"value" => array(
						'Default' => '',
						'Custom 1' => 'block-title__1',
						'Custom 2' => 'block-title__2',
						'Custom 3' => 'block-title__3',
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'lugos'),
					"param_name" => "title",
					'holder' => 'div'
				),
				/*
				array(
					"type" => "textarea",
					"heading" => esc_html__("Subtitle", 'lugos'),
					"param_name" => "subtitle",
				),
				*/
			)
		)
	);
}
add_action( 'vc_before_init', 'thedux_block_title_shortcode_vc' );