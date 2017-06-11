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
				'type_filter' => 'feature',
				'group_by' => 'feature',
				'feature' => '',
				'category'      => '',
				'all_text'		=> 'All Products',
				'load_more'     => false,
				'tab_id' => '',
			), $atts 
		) 
	);
	
	/**
	 * Setup post query
	 */
	
	global $wp_query, $paged, $shop_columns, $product_filter, $product_feature;

	$paged = NULL;
	
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
	
	$product_visibility_term_ids = wc_get_product_visibility_term_ids();

	$query_args = array(
		'post_type'      => 'product',
		'posts_per_page' => $pppage,
		'paged'          => $paged,
		'post_status'    => 'publish',
		'meta_query'     => array(),
		'tax_query'      => array(
			'relation' => 'AND',
		),
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
	
	if($group_by == 'feature'){
		if(isset($feature)){
			
			switch ( $feature ) {
				case 'featured':
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['featured'],
					);
					break;

				case 'sale':
					$product_ids_on_sale    = wc_get_product_ids_on_sale();
					$product_ids_on_sale[]  = 0;
					$query_args['post__in'] = $product_ids_on_sale;
					break;
					
				case 'best_sellers':
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby'] = 'meta_value_num';
					break;

				default:
					break;
			}
			
		}
	}
	
	if($group_by == 'category'){
		if ( empty( $category ) ) {
			$categories = get_terms( array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
			) );
		} else {
			$categories = get_terms( array(
				'taxonomy' => 'product_cat',
				'slug'     => explode( ',', trim( $category ) ),
			) );
			$query_args['product_cat'] = $category;
		}
	}
	
	if(isset($feature) && $feature == 'top_rated' ){
		add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
	}
	
	$custom_query = new WP_Query( $query_args );

	if(isset($feature) && $feature == 'top_rated' ){
		remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
	}

	$old_query = $wp_query;
	$wp_query = NULL;
	$wp_query = $custom_query;
	
	$shop_columns = $columns;
	$product_filter = $type_filter;
	$product_feature = $feature;
	
	ob_start();

	?>
	<div class="lugos__shop-catalog-content" id="<?php echo esc_html($tab_id) ?>">
		<div class="masonry masonry-shop">
			<?php if( $show_filter == 'yes' ): ?>
			<div class="masonry-filter-container text-center">
				<div class="masonry-filter-holder">
					<div class="masonry__filters product-uppercase-filter"><ul>
						<li class="active" data-masonry-filter="*"><?php echo esc_html($all_text) ?></li>
						<li data-masonry-filter="new"><?php echo esc_html__( 'New Products', 'lugos' ) ?></li>
						<li data-masonry-filter="top"><?php echo esc_html__( 'Top Products', 'lugos' ) ?></li>
						<li data-masonry-filter="sale"><?php echo esc_html__( 'Sale Products', 'lugos' ) ?></li>
					</ul></div>
				</div>
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="masonry__container">
					<?php
						if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post();
						
							/**
							 * Get blog posts by blog layout.
							 */
							$catalog_layout = get_option('lugos_shop_catelog_style', 'default');
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
	
	if ( isset( $load_more ) && $load_more && $custom_query->max_num_pages > 1 ) {
	?>
	<nav class="woocommerce-pagination lugos-pagination lugos__load-more">
		<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         	=> esc_url( str_replace( 999999999, '%#%', remove_query_arg( array( 'add-to-cart', 'shop_load', '_', 'infload', 'ajax_filters' ), get_pagenum_link( 999999999, false ) ) ) ),
			'format'       	=> '',
			'current'      	=> max( 1, $paged ),
			'total'        	=> $custom_query->max_num_pages,
			'prev_text'		=> '&larr;',
			'next_text'    	=> '&rarr;',
			'type'         	=> 'list',
			'end_size'     	=> 3,
			'mid_size'     	=> 3
		) ) );
		?>
	</nav>

	<div class="lugos__load-more-link"><?php next_posts_link( '&nbsp;', $custom_query->max_num_pages ); ?></div>

	<div class="lugos__load-more-controls button-mode">
		<a href="#" class="btn btn--dark lugos__load-more-btn"><?php esc_html_e( 'Load More', 'lugos' ); ?></a>
		<div class="loading--more">
		    <div class="btn btn--dark loading-icon">
				<span>.</span><span>.</span><span>.</span>
		    </div>
		</div>
		<a href="#" class="btn btn--border lugos__load-more-complete"><?php esc_html_e( 'All products loaded.', 'lugos' ); ?></a>
	</div>

	<?php
	}
	?>
	</div>
	<?php
	wp_reset_postdata();
	$output = ob_get_contents();
	ob_end_clean();
	$paged = NULL;
	$wp_query = NULL;
	$wp_query = $old_query;
	$custom_query = NULL;
	$product_filter = null;
	$product_feature = null;

	return $output;
}
add_shortcode( 'lugos_product_masonry', 'thedux_product_masonry_shortcode' );

/**
 * The VC Functions
 */
function thedux_product_masonry_shortcode_vc() {

	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Product Masonry", 'lugos'),
			"base" => "lugos_product_masonry",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			'description' => 'Show product posts with layout options.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Products?", 'lugos'),
					"param_name" => "pppage",
					"value" => '12'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Product Columns", 'lugos'),
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
					"heading" => esc_html__("Show Filter?", 'lugos'),
					"param_name" => "show_filter",
					"value" => array(
						"Yes" => "yes",
						"No" => "no"
					)
				),
				array(
					'heading'     => esc_html__( 'Product group by', 'lugos' ),
					'description' => esc_html__( 'Select how to group products in grid', 'lugos' ),
					'param_name'  => 'group_by',
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
						"Recent Products" => 'recent',
						"Featured Products" => 'featured',
						"Sale Products" => 'sale',
						"Best Selling Products" => 'best_sellers',
						"Top Rated Products"    => 'top_rated',
					),
					'dependency'  => array(
						'element' => 'group_by',
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
						'element' => 'group_by',
						'value'   => 'category',
					),
				),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("All Text", 'lugos'),
		    		"param_name" => "all_text",
		    		"value" => 'All Products'
		    	),
				array(
					'heading'     => esc_html__( 'Load More Button', 'lugos' ),
					'param_name'  => 'load_more',
					'type'        => 'checkbox',
					'value'       => array(
						esc_html__( 'Yes', 'lugos' ) => 'yes',
					),
					'description' => esc_html__( 'Show load more button with ajax loading', 'lugos' ),
				),
		    	array(
		    		"type" => "hidden",
		    		"heading" => esc_html__("Block ID", 'lugos'),
		    		"param_name" => "tab_id",
		    		"value" => 'lugos__shop-catalog-'.time().wp_rand( 1, 100 ),
		    	),
			)
		) 
	);
}
add_action( 'vc_before_init', 'thedux_product_masonry_shortcode_vc');
