<?php 

/**
 * The Shortcode
 */
function thedux_hover_tile_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'image' => '',
				'type' => 'top,left',
				'link' => '#',
				'title' => '',
				'subtitle' => ''
			), $atts 
		) 
	);
	
	$output = '
		<a href="'. esc_url($link) .'">
			<div class="hover-element hover-element-1 bg--primary" data-title-position="'. $type .'">
				<div class="hover-element__initial">
					'. wp_get_attachment_image( $image, 'large' ) .'
				</div>
				<div class="hover-element__reveal" data-overlay="9">
					<div class="boxed">
						<h5>'. htmlspecialchars_decode($title) .'</h5>
						<span><em>'. htmlspecialchars_decode($subtitle) .'</em></span>
					</div>
				</div>
			</div><!--end hover element-->
		</a>
	';
	
	return $output;
}
add_shortcode( 'caviar_hover_tile', 'thedux_hover_tile_shortcode' );

/**
 * The VC Functions
 */
function thedux_hover_tile_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Hover Tiles", 'caviar'),
			"base" => "caviar_hover_tile",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Block Image", 'caviar'),
					"param_name" => "image"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'caviar'),
					"param_name" => "type",
					"value" => array(
						'Top Left' => 'top,left',
						'Top Right' => 'top,right',
						'Center Left' => 'center,left',
						'Center Right' => 'center,right',
						'Bottom Left' => 'bottom,left',
						'Bottom Right' => 'bottom,right',
						'Centered' => 'top,center',
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'caviar'),
					"param_name" => "title",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Subtitle", 'caviar'),
					"param_name" => "subtitle",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("URL for block", 'caviar'),
					"param_name" => "link"
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_hover_tile_shortcode_vc' );