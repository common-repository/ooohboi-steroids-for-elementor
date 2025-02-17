<?php
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main OoohBoi Overlaiz
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class OoohBoi_Overlaiz {

	/**
	 * Initialize 
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public static function init() {

		add_action( 'elementor/element/section/section_background_overlay/before_section_end',  [ __CLASS__, 'ooohboi_overlaiz_get_controls' ], 10, 2 );
		add_action( 'elementor/element/column/section_background_overlay/before_section_end',  [ __CLASS__, 'ooohboi_overlaiz_get_controls' ], 10, 2 );

	}
	
	public static function ooohboi_overlaiz_get_controls( $element, $args ) {

		// selector based on the current element
		$selector = '{{_WRAPPER}} {{WRAPPER}} > .elementor-column-wrap > .elementor-background-overlay';
		if( 'section' == $element->get_name() ) 
			$selector = '{{_WRAPPER}} {{WRAPPER}} > .elementor-background-overlay'; 


		$element->add_control(
			'_ob_overlaiz_plugin_title',
			[
				'label' => 'O V E R L A I Z', 
				'type' => Controls_Manager::HEADING,
				'separator' => 'before', 
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		// ------------------------------------------------------------------------- CONTROL: background overlay width
		$element->add_responsive_control(
			'_ob_overlaiz_width',
			[
				'label' => __( 'Width', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'default_tablet' => [
					'unit' => '%',
					'size' => 100,
				],
				'default_mobile' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => 5,
						'max' => 500,
					],
				],
				'selectors' => [
					$selector => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'selectors' => [
							$selector => 'width: {{SIZE}}{{UNIT}};',
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'selectors' => [
							$selector => 'width: {{SIZE}}{{UNIT}};',
						],
					],
				],
			]
		);
		// ------------------------------------------------------------------------- CONTROL: background overlay height
		$element->add_responsive_control(
			'_ob_overlaiz_height',
			[
				'label' => __( 'Height', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'default_tablet' => [
					'unit' => '%',
					'size' => 100,
				],
				'default_mobile' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => 5,
						'max' => 500,
					],
				],
				'selectors' => [
					$selector => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'selectors' => [
							$selector => 'height: {{SIZE}}{{UNIT}};',
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'selectors' => [
							$selector => 'height: {{SIZE}}{{UNIT}};',
						],
					],
				],
			]
		);
		// ------------------------------------------------------------------------- CONTROL: move background overlay - X
		$element->add_responsive_control(
			'_ob_overlaiz_move_bg_x',
			[
				'label' => __( 'Position - X', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'default_tablet' => [
					'unit' => '%',
					'size' => 0,
				],
				'default_mobile' => [
					'unit' => '%',
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					$selector => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'selectors' => [
							$selector => 'left: {{SIZE}}{{UNIT}};',
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'selectors' => [
							$selector => 'left: {{SIZE}}{{UNIT}};',
						],
					],
				],
			]
		);
		// ------------------------------------------------------------------------- CONTROL: Magic Overlays - move background overlay - Y
		$element->add_responsive_control(
			'_ob_overlaiz_move_bg_y',
			[
				'label' => __( 'Position - Y', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'default_tablet' => [
					'unit' => '%',
					'size' => 0,
				],
				'default_mobile' => [
					'unit' => '%',
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					$selector => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'selectors' => [
							$selector => 'top: {{SIZE}}{{UNIT}};',
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'selectors' => [
							$selector => 'top: {{SIZE}}{{UNIT}};',
						],
					],
				],
			]
		);

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER
		$element->add_control(
			'_ob_overlaiz_popover_border',
			[
				'label' => __( 'Border', 'ooohboi-steroids' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER ALL
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_ob_overlaiz_borders', 
				'label' => __( 'Border', 'ooohboi-steroids' ), 
				'selector' => $selector, 
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER RADIUS
		$element->add_responsive_control(
			'_ob_overlaiz_border_rad',
			[
				'label' => __( 'Border Radius', 'ooohboi-steroids' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					$selector  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$element->end_popover(); // popover BORdER end

	}

}