<?php 

/**
 * The Shortcode
 */
function thedux_blog_posts_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'type' => 'grid',
				'pppage' => '6',
				'columns' => '4',
				'filter' => 'all'
			), $atts 
		) 
	);
	
	// Fix for pagination
	global $paged;
	
	if( is_front_page() ) { 
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; 
	} else { 
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
	}
	
	/**
	 * Setup post query
	 */
	$query_args = array(
		'post_type' => 'post',
		'posts_per_page' => $pppage,
		'paged' => $paged
	);
	
	if (!( $filter == 'all' )) {
		if( function_exists( 'icl_object_id' ) ){
			$filter = (int)icl_object_id( $filter, 'category', true);
		}
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $filter
			)
		);
	}

	global $wp_query, $post;
	$old_query = $wp_query;
	$old_post = $post;
	$wp_query = new WP_Query( $query_args );
	
	$blog_columns = '';
	
	switch( $columns ):
		case 2:
			$blog_columns = 'col-sm-6';
			break;
		case 3:
			$blog_columns = 'col-sm-4';
			break;
		case 4:
			$blog_columns = 'col-sm-3';
			break;
		default:
			$blog_columns = 'col-sm-4';
			break;
	endswitch;
	
	ob_start();
	
	if($type == 'list'){
	?>
	<div class="row">
		<div class="masonry masonry-blog-list">
			<div class="masonry__container blog-load-more">
				<?php
					if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
					?>
						<div class="shortcode__latest-post col-md-12 col-sm-12 masonry__item">
							<?php if( has_post_thumbnail() ) : ?>
							<div class="latest-post_thumb">

								<img alt="<?php the_title()?>" src="<?php  the_post_thumbnail_url('large')?>" />

								<div class="latest-post__date">
									<?php echo get_the_time('d'); ?>
									<span><?php echo get_the_time('M'); ?></span>
								</div>
							</div>
							<?php endif; ?>
							<div class="latest-post__body text-center">
								<a class="latest-post__title ajax-link" href="<?php the_permalink() ?>">
									<?php the_title() ?>
								</a>
								<p class="latest-post__bottom"><a href="<?php the_permalink() ?>" class="btn btn--border btn--sm ajax-link"><?php esc_html_e('Read More','caviar') ?></a> </p>
							</div>
						</div>
					<?php
					endwhile;	
					endif;
				?>
			</div>
		</div>
	</div>
	<?php
	} elseif($type == 'grid'){
	?>
	<div class="row">
		<div class="masonry masonry-blog-grid">
			<div class="masonry__container blog-load-more">
				<?php
					if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
					?>
						<div class="shortcode__latest-post <?php echo $blog_columns ?> masonry__item">
							<div class="blog-content">
								<?php if( has_post_thumbnail() ) : ?>
								<div class="latest-post_thumb">
									<a href="<?php the_permalink() ?>" class="block ajax-link">
										<img alt="<?php the_title()?>" src="<?php  the_post_thumbnail_url('large')?>" />
									</a>
								</div>
								<?php endif; ?>
								<a class="ajax-link" href="<?php the_permalink() ?>"><h3><?php the_title()?></h3></a>
								<p><?php echo wp_trim_words( get_the_content(), 20 ); ?> <a href="<?php the_permalink() ?>"><?php esc_html_e('More','caviar') ?> ➜</a></p>
							</div>
						</div>
					<?php
					endwhile;	
					endif;
				?>
			</div>
		</div>
	</div>
	<?php
	} elseif($type == 'grid_2'){
	?>
	<div class="row">
		<div class="masonry masonry-blog-grid_2">
			<div class="masonry__container blog-load-more">
				<?php
					if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
					?>
						<div class="shortcode__latest-post <?php echo $blog_columns ?> masonry__item">
							<div class="blog-content">
								<?php if( has_post_thumbnail() ) : ?>
								<div class="latest-post_thumb">
									<a href="<?php the_permalink() ?>" class="block ajax-link">
										<img alt="<?php the_title()?>" src="<?php  the_post_thumbnail_url('large')?>" />
									</a>
									<?php
									$categories = get_the_category();
									if ( ! empty( $categories ) ) {
									?>
									<div class="latest-post__cate">
										<?php echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>'; ?>
									</div>
									<?php
									}
									?>
								</div>
								<?php endif; ?>
								<a class="ajax-link" href="<?php the_permalink() ?>"><?php the_title()?></a>
								<p><?php echo wp_trim_words( get_the_content(), 15 ); ?></p>
							</div>
						</div>
					<?php
					endwhile;	
					endif;
				?>
			</div>
		</div>
	</div>	
	<?php
	} elseif($type == 'slider'){
	?>
	<div class="owl-slider owl-carousel owl-theme" data-dots="true">
		<?php
			if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
			?>
			
				<div class="slide-item">
					<div class="shortcode__latest-post">
						<?php if( has_post_thumbnail() ) : ?>
						<div class="latest-post_thumb">
							<a href="<?php the_permalink() ?>" class="block ajax-link">
								<img alt="<?php the_title()?>" src="<?php  the_post_thumbnail_url('large')?>" />
							</a>
							<div class="latest-post__date">
								<?php echo get_the_time('d'); ?>
								<span><?php echo get_the_time('M'); ?></span>
							</div>
						</div>
						<?php endif; ?>
						<div class="latest-post__body text-center">
							<a class="latest-post__title" href="<?php the_permalink() ?>">
								<?php the_title() ?>
							</a>
							<p class="latest-post__bottom"><a href="<?php the_permalink() ?>" class="btn btn--border btn--sm"><?php esc_html_e('Read More','caviar') ?></a> </p>
						</div>
					</div>
				</div>
			
			<?php
			endwhile;	
			endif;
		?>
	</div>
	<?php
	}
	
	$output = ob_get_contents();
	ob_end_clean();
	
	wp_reset_postdata();
	$wp_query = $old_query;
	$post = $old_post;
	
	return $output;
}
add_shortcode( 'caviar_blog_posts', 'thedux_blog_posts_shortcode' );

/**
 * The VC Functions
 */
function thedux_blog_posts_shortcode_vc() {
	
	$blog_types = thedux_get_blog_layouts();
	
	vc_map( 
		array(
			"icon" => 'caviar-vc-block',
			"name" => esc_html__("Blog Posts", 'caviar'),
			"base" => "caviar_blog_posts",
			"category" => esc_html__('Caviar Theme', 'caviar'),
			'description' => 'Show blog posts with layout options.',
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display type", 'caviar'),
					"param_name" => "type",
					"value" => array(
						"Grid" => 'grid',
						"Grid 2" => 'grid_2',
						"Slider" => 'slider',
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Posts?", 'caviar'),
					"param_name" => "pppage",
					"value" => '6'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Column", 'caviar'),
					"param_name" => "columns",
					"dependency" => array(
						"element" => "type",
						"value" => array('grid','grid_2'),
					),
					"value" => array(
						'3' => '3',
						'2' => '2',
						'4' => '4',
					)
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'thedux_blog_posts_shortcode_vc');