<?php 

/**
 * The Shortcode
 */
function thedux_product_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'pppage' => '12',
				'filter' => 'all',
				'layout' => 'none-sidebar'
			), $atts 
		) 
	);
	
	/**
	 * Setup post query
	 */
	$query_args = array(
		'post_type' => 'product',
		'posts_per_page' => $pppage
	);
	
	if (!( $filter == 'all' )) {
		if( function_exists( 'icl_object_id' ) ){
			$filter = (int)icl_object_id( $filter, 'product_category', true);
		}
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'product_category',
				'field' => 'id',
				'terms' => $filter
			)
		);
	}
	
	global $wp_query;
	$old_query = $wp_query;
	$wp_query = new WP_Query( $query_args );
	
	ob_start();

	get_template_part('loop/loop-shop', $layout);
	
	$output = ob_get_contents();
	ob_end_clean();
	
	wp_reset_postdata();
	$wp_query = $old_query;
	
	return $output;
}
add_shortcode( 'lugos_product', 'thedux_product_shortcode' );

/**
 * The VC Functions
 */
function thedux_product_shortcode_vc() {
	
	$shop_layouts = thedux_get_shop_layouts();
	
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Product Feeds", 'lugos'),
			"base" => "lugos_product",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			'description' => 'Show product posts with layout options.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Posts?", 'lugos'),
					"param_name" => "pppage",
					"value" => '12'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("product Display Type", 'lugos'),
					"param_name" => "layout",
					"value" => $shop_layouts
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_product_shortcode_vc');
