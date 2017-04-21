<?php

/**
 * The Shortcode
 */
function thedux_product_masonry_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'pppage' => '12',
				'columns' => '4',
				'filter' => 'all',
				'show_filter' => 'yes',
				'type_filter' => 'category',
				'category'      => '',
				'load_more'     => false,
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
	
	global $wp_query, $shop_columns, $product_filter;
	$old_query = $wp_query;
	$wp_query = new WP_Query( $query_args );
	
	$shop_columns = $columns;
	$product_filter = $type_filter;
	
	ob_start();

	?>
				<div class="masonry masonry-shop">
					<?php if( $show_filter == 'yes' ): ?>
					<div class="masonry-filter-container text-center">
						<div class="masonry-filter-holder">
							<div class="masonry__filters product-uppercase-filter" data-filter-all-text="<?php esc_html_e("All Products", 'caviar') ?>"></div>
						</div>
					</div>
					<?php endif; ?>
					<div class="row">
						<div class="masonry__container <?php echo esc_attr(get_option('animated_masonry', 'masonry--animate')); ?>">
							<?php
								if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
								
									/**
									 * Get blog posts by blog layout.
									 */
									$catalog_layout = get_option('caviar_shop_catelog_style', 'default');
									get_template_part('loop/content-catalog', $catalog_layout);
								
								endwhile;	
								else : 
									
									/**
									 * Display no posts message if none are found.
									 */
									get_template_part('loop/content','none');
									
								endif;
							?>
						</div><!--end masonry container-->
					</div><!--end row-->
				</div><!--end masonry-->
	<?php
	
	$output = ob_get_contents();
	ob_end_clean();
	
	wp_reset_postdata();
	$wp_query = $old_query;
	$product_filter = null;
	
	return $output;
}
add_shortcode( 'caviar_product_masonry', 'thedux_product_masonry_shortcode' );

/**
 * The VC Functions
 */
function thedux_product_masonry_shortcode_vc() {

	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Product Masonry", 'caviar'),
			"base" => "caviar_product_masonry",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			'description' => 'Show product posts with layout options.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Products?", 'caviar'),
					"param_name" => "pppage",
					"value" => '12'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Product Columns", 'caviar'),
					"param_name" => "columns",
					"value" => array(
						"2 Columns" => '2',
						"3 Columns" => '3',
						"4 Columns" => '4'
					),
					"std" => '4'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Show Filter?", 'caviar'),
					"param_name" => "show_filter",
					"value" => array(
						"Yes" => "yes",
						"No" => "no"
					)
				),
				array(
					'heading'     => esc_html__( 'Filter Type', 'caviar' ),
					'description' => esc_html__( 'Select how to group products in grid', 'caviar' ),
					'param_name'  => 'type_filter',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Group by feature', 'caviar' )  => 'group',
						esc_html__( 'Group by category', 'caviar' ) => 'category',
					),
				),
				array(
					'heading'     => esc_html__( 'Categories', 'caviar' ),
					'description' => esc_html__( 'Select what categories you want to use. Leave it empty to use all categories.', 'caviar' ),
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
				array(
					'heading'     => esc_html__( 'Load More Button', 'caviar' ),
					'param_name'  => 'load_more',
					'type'        => 'checkbox',
					'value'       => array(
						esc_html__( 'Yes', 'caviar' ) => 'yes',
					),
					'description' => esc_html__( 'Show load more button with ajax loading', 'caviar' ),
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_product_masonry_shortcode_vc');
