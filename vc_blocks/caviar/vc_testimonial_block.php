<?php 

/**
 * The Shortcode
 */
function thedux_testimonial_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'pppage' => '5',
				'filter' => 'all',
				'layout' => 'carousel'
			), $atts 
		) 
	);
	
	/**
	 * Setup post query
	 */
	$query_args = array(
		'post_type' => 'testimonial',
		'posts_per_page' => $pppage
	);
	
	if (!( $filter == 'all' )) {
		if( function_exists( 'icl_object_id' ) ){
			$filter = (int)icl_object_id( $filter, 'testimonial_category', true);
		}
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial_category',
				'field' => 'id',
				'terms' => $filter
			)
		);
	}
	
	global $wp_query, $post;
	$old_query = $wp_query;
	$old_post = $post;
	$wp_query = new WP_Query( $query_args );
	
	ob_start();

	get_template_part('loop/loop-testimonial', $layout);
	
	$output = ob_get_contents();
	ob_end_clean();
	
	wp_reset_postdata();
	$wp_query = $old_query;
	$post = $old_post;
	
	return $output;
}
add_shortcode( 'caviar_testimonial', 'thedux_testimonial_shortcode' );

/**
 * The VC Functions
 */
function thedux_testimonial_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Testimonial Feeds", 'caviar'),
			"base" => "caviar_testimonial",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			'description' => 'Show testimonial posts with layout options.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Posts?", 'caviar'),
					"param_name" => "pppage",
					"value" => '4'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Testimonial Display Type", 'caviar'),
					"param_name" => "layout",
					"value" => array(
						'Carousel' => 'carousel',
						'Large' => 'large',
						'Grid' => 'grid',
						'Large Grid' => 'grid-large',
						'Avatar Slider' => 'avatar-slider'
					)
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_testimonial_shortcode_vc');
