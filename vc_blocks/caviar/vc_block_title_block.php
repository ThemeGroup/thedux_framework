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
	
	$output = '<div class="caviar-block-title '.$type.'"><h4>'. htmlspecialchars_decode($title) .'</h4></div>';
	
	return $output;
}
add_shortcode( 'caviar_block_title', 'thedux_block_title_shortcode' );

/**
 * The VC Functions
 */
function thedux_block_title_shortcode_vc(){
	vc_map(
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Block Title", 'caviar'),
			"base" => "caviar_block_title",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'caviar'),
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
					"heading" => esc_html__("Title", 'caviar'),
					"param_name" => "title",
					'holder' => 'div'
				),
				/*
				array(
					"type" => "textarea",
					"heading" => esc_html__("Subtitle", 'caviar'),
					"param_name" => "subtitle",
				),
				*/
			)
		)
	);
}
add_action( 'vc_before_init', 'thedux_block_title_shortcode_vc' );