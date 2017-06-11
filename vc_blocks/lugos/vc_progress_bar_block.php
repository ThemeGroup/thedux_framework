<?php 

/**
 * The Shortcode
 */
function thedux_skill_bar_block_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'amount' => '',
				'layout' => 'horizontal-thick',
				'icon' => ''
			), $atts 
		) 
	);
	
	if( 'horizontal-thick' == $layout ){
		
		$output = '
			<div class="barchart barchart-1" data-value="'. $amount .'">
				<div class="barchart__description">
					<span class="h6">'. $title .'</span>
				</div>
				<div class="barchart__bar">
					<div class="barchart__progress"></div>
				</div>
			</div><!--end of barchart-->
		';	
		
	} elseif( 'horizontal-thin' == $layout ){
		
		$output = '
			<div class="barchart barchart-2" data-value="'. $amount .'">
				<div class="barchart__description">
					<span class="h6">'. $title .'</span>
				</div>
				<div class="barchart__bar">
					<div class="barchart__progress"></div>
				</div>
			</div><!--end of barchart-->
		';	
		
	} elseif( 'vertical-thick' == $layout ){
		
		$output = '
			<div class="barchart barchart--vertical barchart-1" data-value="'. $amount .'">
				<div class="barchart__bar">
					<div class="barchart__progress"></div>
				</div>
				<div class="barchart__description">
					<span class="h6">'. $title .'</span>
				</div>
			</div><!--end of barchart-->
		';	
		
	} elseif( 'vertical-thin' == $layout ){
		
		$output = '
			<div class="barchart barchart--vertical barchart-2" data-value="'. $amount .'">
				<div class="barchart__bar">
					<div class="barchart__progress"></div>
				</div>
				<div class="barchart__description">
					<span class="h6">'. $title .'</span>
				</div>
			</div><!--end of barchart-->
		';	
		
	} elseif( 'percentage-radial' == $layout ){
		
		$output = '
			<div class="text-center">
				<h6>'. $title .'</h6>
				<div class="piechart piechart-1" data-size="200" data-value="'. $amount .'">
					<div class="piechart__overlay">
						<div class="piechart__description">
							<span class="h3">'. $amount .'%</span>
						</div>
					</div>
				</div>
			</div>
		';	
		
	} elseif( 'titled-radial' == $layout ){
		
		$output = '
			<div class="text-center">
				<div class="piechart piechart-1" data-size="200" data-value="'. $amount .'">
					<div class="piechart__overlay">
						<div class="piechart__description">
							<span class="h5">'. $title .'</span>
						</div>
					</div>
				</div>
			</div>
		';	
		
	} elseif( 'process-radial' == $layout ){
		
		$output = '
			<div class="text-center">
				<div class="piechart piechart-2" data-size="200" data-value="'. $amount .'">
					<div class="piechart__overlay">
						<div class="piechart__description">
							<h6>'. $title .'</h6>
							<span class="h4">'. $amount .'%</span>
						</div>
					</div>
				</div>
			</div>
		';	
		
	} elseif( 'icon-radial' == $layout ){
	
		$output = '
			<div class="piechart piechart-3" data-size="200" data-value="'. $amount .'">
				<div class="piechart__overlay">
					<div class="piechart__description">
						<i class="'. esc_attr($icon) .'"></i>
					</div>
				</div>
			</div>
		';
	
	}
	
	return $output;
}
add_shortcode( 'lugos_skill_bar_block', 'thedux_skill_bar_block_shortcode' );

/**
 * The VC Functions
 */
function thedux_skill_bar_block_shortcode_vc() {
	
	$icons = array('Install Themedeux Framework' => 'Install Themedeux Framework');
	
	if( function_exists('thedux_get_icons') ){
		$icons = thedux_get_icons();	
	}
	
	vc_map( 
		array(
			"icon" => 'lugos-vc-block',
			"name" => esc_html__("Progress Bar", 'lugos'),
			"base" => "lugos_skill_bar_block",
			"category" => esc_html__('Lugos Theme', 'lugos'),
			'description' => 'Coloured bars for demonstrating your skills.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Skill Title", 'lugos'),
					"param_name" => "title",
					'holder' => 'div'
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Skill Amount", 'lugos'),
					"param_name" => "amount",
					'description' => 'Use a value between 0 - 100 only.'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display Type", 'lugos'),
					"param_name" => "layout",
					"value" => array(
						'Horizontal Thick Bar' => 'horizontal-thick',
						'Horizontal Thin Bar' => 'horizontal-thin',
						'Vertical Thick Bar' => 'vertical-thick',
						'Vertical Thin Bar' => 'vertical-thin',
						'Percentage Radial' => 'percentage-radial',
						'Titled Radial' => 'titled-radial',
						'Process Radial' => 'process-radial',
						'Icon Radial' => 'icon-radial'
					)
				),
				array(
					"type" => "thedux_icons",
					"heading" => esc_html__("Click an Icon to choose", 'lugos'),
					"param_name" => "icon",
					"value" => $icons,
					'description' => 'Type "none" or leave blank to hide icons.'
				),
			)
		) 
	);
	
}
add_action( 'vc_before_init', 'thedux_skill_bar_block_shortcode_vc' );