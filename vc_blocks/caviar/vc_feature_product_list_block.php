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
			), $atts 
		) 
	);
	
	/**
	 * Setup post query
	 */
	$meta_query   = WC()->query->get_meta_query();
	$meta_query[] = array(
		'key'   => '_featured',
		'value' => 'yes'
	);

	$query_args = array(
		'post_type' => 'product',
		'posts_per_page' => $pppage,
		'meta_query'  =>  $meta_query
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
				<li class="feature-product-item"><span class="feature-product-price"><?php echo woocommerce_template_loop_price(); ?></span> <a href="<?php the_permalink(); ?>" data-productid="<?php the_ID(); ?>" class="feature-product-title"><?php the_title(); ?></a></li>
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
add_shortcode( 'caviar_feature_product_list', 'thedux_feature_product_list_shortcode' );

/**
 * The VC Functions
 */
function thedux_feature_product_list_shortcode_vc() {
	vc_map(
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Feature Product List", 'caviar'),
			"base" => "caviar_feature_product_list",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			'description' => 'Show product posts with layout options.',
			"params" => array(
				array(
					"type" => "textarea",
					"heading" => esc_html__("Subtitle", 'caviar'),
					"param_name" => "subtitle",
					"value" => ""
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Products?", 'caviar'),
					"param_name" => "pppage",
					"value" => '10'
				),
			)
		)
	);
}
add_action( 'vc_before_init', 'thedux_feature_product_list_shortcode_vc');
