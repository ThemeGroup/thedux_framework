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
				'show_filter' => 'yes'
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
	
	global $wp_query, $shop_columns;
	$old_query = $wp_query;
	$wp_query = new WP_Query( $query_args );
	
	$shop_columns = $columns;
	
	ob_start();

	//get_template_part('loop/loop-shop', $layout);
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
					"heading" => esc_html__("Show Filter?", 'caviar'),
					"param_name" => "show_filter",
					"value" => array(
						"Yes" => "yes",
						"No" => "no"
					)
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
				)
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_product_masonry_shortcode_vc');
