<?php 

/**
 * The Shortcode
 */
function thedux_carousel_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'count' => '4',
				'timing' => '7000'
			), $atts 
		) 
	);
	
	$image = explode(',', $image);
	
	$output = '<div class="slider slider--controlsoutside screenshot-slider" data-items="'. (int) esc_attr($count) .'" data-paging="true" data-arrows="false" data-timing="'. (int) esc_attr($timing) .'"><ul class="slides">';
	
	foreach ($image as $id){
		$output .= '
			<li>
				<div class="col-sm-12">
					'. wp_get_attachment_image($id, 'large') .'
				</div>
			</li>
		';
	}
				
	$output .= '</ul></div>';
		
	return $output;
}
add_shortcode( 'caviar_carousel', 'thedux_carousel_shortcode' );

/**
 * The VC Functions
 */
function thedux_carousel_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Image Carousel", 'caviar'),
			"base" => "caviar_carousel",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			"params" => array(
				array(
					"type" => "attach_images",
					"heading" => esc_html__("Carousel Images", 'caviar'),
					"param_name" => "image"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Images Per Page", 'caviar'),
					"param_name" => "count",
					'value' => '4'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Autoplay Timer (ms)", 'caviar'),
					"param_name" => "timing",
					'value' => '7000'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_carousel_shortcode_vc' );