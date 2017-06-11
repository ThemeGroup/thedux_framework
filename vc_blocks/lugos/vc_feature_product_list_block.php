<?php

/**
 * The Shortcode
 */
function thedux_feature_product_list_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'subtitle' => '',
				'pppage' => '10',
				'filter' => 'all',
				'type_filter' => 'feature',
				'feature' => '',
				'category' => '',
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
	
	if($type_filter == 'feature'){
		if( ! empty( $feature ) ){
			
			switch ( $feature ) {
				case 'featured':
					$query_args['meta_query'][] = array(
						'key'   => '_featured',
						'value' => 'yes',
					);
					break;

				case 'sale':
					$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
					break;

				default:
					break;
			}
			
		}
	}
	
	if($type_filter == 'category'){
		if ( empty( $category ) ) {
			$categories = get_terms( 'product_cat' );
		} else {
			$categories = get_terms( array(
				'taxonomy' => 'product_cat',
				'slug'     => explode( ',', trim( $category ) ),
			) );
			$query_args['product_cat'] = $category;
		}
	}
	
	global $wp_query;
	$old_query = $wp_query;
	$wp_query = new WP_Query( $query_args );

	ob_start();
	
	if ( $wp_query->have_posts() ) :
	?>
	
	<div class="row feature-product-wrap">
		<div class="col-sm-6">
			<h5><?php echo htmlspecialchars_decode($subtitle) ?></h5>
			<ul class="feature-product-list">
				<?php
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				global $product, $woocommerce;
				?>
				<li class="feature-product-item"><span class="feature-product-price"><?php echo woocommerce_template_loop_price(); ?></span> <a href="<?php the_permalink(); ?>" data-productid="<?php the_ID(); ?>" class="feature-product-title ajax-link"><?php the_title(); ?></a></li>
				<?php
				endwhile;
				?>
			</ul>
		</div>		
		<div class="col-sm-6">
			<div class="feature-product-thumbnails">
				<?php
				$productcount = 0;
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				global $product, $woocommerce;
				$productcount++;
				?>
				<?php the_post_thumbnail( array( 370, 450 ), array( 'class' => 'feature-product-image '.($productcount == 1 ? 'active' : ''), 'id' => 'productid-'.get_the_ID() ) ); ?>
				<?php
				endwhile;
				?>
			</div>
		</div>
	</div>
	
	<?php
	endif;
	
	$output = ob_get_contents();
	ob_end_clean();
	
	wp_reset_postdata();
	$wp_query = $old_query;
	
	return $output;
}
add_shortcode( 'lugos_feature_product_list', 'thedux_feature_product_list_shortcode' );

/**
 * The VC Functions
 */
function thedux_feature_product_list_shortcode_vc() {
	vc_map(
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Feature Product List", 'lugos'),
			"base" => "lugos_feature_product_list",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			'description' => 'Show product posts with layout options.',
			"params" => array(
				array(
					"type" => "textarea",
					"heading" => esc_html__("Subtitle", 'lugos'),
					"param_name" => "subtitle",
					"value" => ""
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Products?", 'lugos'),
					"param_name" => "pppage",
					"value" => '10'
				),
				array(
					'heading'     => esc_html__( 'Filter Type', 'lugos' ),
					'description' => esc_html__( 'Select how to group products in grid', 'lugos' ),
					'param_name'  => 'type_filter',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Group by feature', 'lugos' )  => 'feature',
						esc_html__( 'Group by category', 'lugos' ) => 'category',
					),
				),
				array(
					"type" => "dropdown",
					'heading' => esc_html__( 'Feature attribute', 'lugos' ),
					"param_name" => "feature",
					"value" => array(
						"All Products" => '',
						"Recent Products" => 'recent',
						"Featured Products" => 'featured',
						"Sale Products" => 'sale',
					),
					'dependency'  => array(
						'element' => 'type_filter',
						'value'   => 'feature',
					),
					
				),
				array(
					'heading'     => esc_html__( 'Categories', 'lugos' ),
					'description' => esc_html__( 'Select what categories you want to use. Leave it empty to use all categories.', 'lugos' ),
					'param_name'  => 'category',
					'type'        => 'autocomplete',
					'value'       => '',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
						'values'   => thedux_get_terms(),
					),
					'dependency'  => array(
						'element' => 'type_filter',
						'value'   => 'category',
					),
				),
			)
		)
	);
}
add_action( 'vc_before_init', 'thedux_feature_product_list_shortcode_vc');
