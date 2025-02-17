<?php
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Element_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main OoohBoi Underlay Overlay Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
class OoohBoi_Overlay_Underlay {

	/**
	 * Initialize 
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public static function init() {

		add_action( 'elementor/element/common/_section_background/after_section_end',  [ __CLASS__, 'add_section' ] );
		add_action( 'elementor/element/after_add_attributes',  [ __CLASS__, 'add_attributes' ] );
		// Document Settings
		add_action( 'elementor/element/post/document_settings/before_section_end', [ __CLASS__, 'poopart_remove_horizontal_scroller' ] );

	}

	public static function add_attributes( Element_Base $element ) {

        if ( in_array( $element->get_name(), [ 'column', 'section' ] ) ) {
            return;
        }

        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
            return;
        }

		$settings = $element->get_settings_for_display();

		//error_log( print_r( $settings, true ) ); // good for the list of fields

		$overlay_bg  = isset( $settings[ '_ob_steroids_overlay_background_background' ] ) ? $settings[ '_ob_steroids_overlay_background_background' ] : '';
		$underlay_bg = isset( $settings[ '_ob_steroids_underlay_background_background' ] ) ? $settings[ '_ob_steroids_underlay_background_background' ] : '';
		
		$has_background_overlay = ( in_array( $overlay_bg, [ 'classic', 'gradient' ], true ) || in_array( $underlay_bg, [ 'classic', 'gradient' ], true ) );

        if ( $has_background_overlay ) {
            $element->add_render_attribute( '_wrapper', 'class', 'ob-has-background-overlay' );
        }

    }

    public static function add_section( Element_Base $element ) {

		$element->start_controls_section(
            '_ob_steroids_background_overlay',
            [
                'label' => 'P O O P A R T',
				'tab' => Controls_Manager::TAB_ADVANCED, 
            ]
		);

		// --------------------------------------------------------------------------------------------- START 2 TABS Overlay & Underlay
		$element->start_controls_tabs( '_ob_steroids_tabs' );

		// --------------------------------------------------------------------------------------------- START TAB Overlay
        $element->start_controls_tab(
            '_ob_steroids_tab_overlay',
            [
                'label' => __( 'Overlay', 'ooohboi-steroids' ),
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_ob_steroids_overlay_background',
                'selector' => '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before',
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND OPACITY
        $element->add_control(
            '_ob_steroids_overlay_bg_opacity',
            [
                'label' => __( 'Opacity', 'ooohboi-steroids' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.7,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'opacity: {{SIZE}};',
				],
				'condition' => [
                    '_ob_steroids_overlay_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL FILTERS
		$element->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_ob_steroids_overlay_bg_filters',
                'selector' => '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before',
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BLEND MODE
        $element->add_control(
            '_ob_steroids_overlay_bg_blend_mode',
            [
                'label' => __( 'Blend Mode', 'ooohboi-steroids' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'Normal', 'ooohboi-steroids' ),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'mix-blend-mode: {{VALUE}}',
                ],
            ]
        );
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER W H Y X Rot
		$element->add_control(
            '_ob_steroids_overlay_popover_whyxrot',
            [
                'label' => __( 'Position and Size', 'ooohboi-steroids' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
                'frontend_available' => true,
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH
        $element->add_responsive_control(
            '_ob_steroids_overlay_w',
            [
				'label' => __( 'Width', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT
        $element->add_responsive_control(
            '_ob_steroids_overlay_h',
            [
				'label' => __( 'Height', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP
		$element->add_responsive_control(
			'_ob_steroids_overlay_y',
			[
				'label' => __( 'Offset Top', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT
		$element->add_responsive_control(
			'_ob_steroids_overlay_x',
			[
				'label' => __( 'Offset Left', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER ROTATION
		# NOTE : this is the hack. Elementor does not do well with 'deg' when speaking of responsiveness!
		$element->add_responsive_control(
			'_ob_steroids_overlay_rot',
			[
				'label' => __( 'Rotate', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$element->end_popover(); // popover end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER
		$element->add_control(
            '_ob_steroids_overlay_popover_border',
            [
                'label' => __( 'Border', 'ooohboi-steroids' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
                'frontend_available' => true,
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER ALL
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_ob_steroids_overlay_borders', 
				'label' => __( 'Border', 'ooohboi-steroids' ), 
				'selector' => '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before', 
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER RADIUS
		$element->add_responsive_control(
			'_ob_steroids_overlay_border_rad',
			[
				'label' => __( 'Border Radius', 'ooohboi-steroids' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$element->end_popover(); // popover BORdER end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ
		$element->add_control(
            '_ob_steroids_overlay_popover_masq',
            [
                'label' => __( 'Overlay Mask', 'ooohboi-steroids' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'_ob_steroids_overlay_background_background' => [ 'classic', 'gradient' ], 
				],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ IMAGE
		$element->add_responsive_control(
			'_ob_steroids_overlay_mask_img',
			[
				'label' => __( 'Choose Image Mask', 'ooohboi-steroids' ),
				'description' => __( 'NOTE: Image Mask should be black-and-transparent SVG file! Anything that’s 100% black in the image mask with be completely visible, anything that’s transparent will be completely hidden.', 'ooohboi-steroids' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-image: url("{{URL}}"); mask-image: url("{{URL}}"); -webkit-mask-mode: alpha; mask-mode: alpha;',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ POSITION
		$element->add_responsive_control(
			'_ob_steroids_overlay_mask_position',
			[
				'label' => __( 'Mask position', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'initial',
				'options' => [
					'' => __( 'Default', 'ooohboi-steroids' ),
					'center center' => __( 'Center Center', 'ooohboi-steroids' ),
					'center left' => __( 'Center Left', 'ooohboi-steroids' ),
					'center right' => __( 'Center Right', 'ooohboi-steroids' ),
					'top center' => __( 'Top Center', 'ooohboi-steroids' ),
					'top left' => __( 'Top Left', 'ooohboi-steroids' ),
					'top right' => __( 'Top Right', 'ooohboi-steroids' ),
					'bottom center' => __( 'Bottom Center', 'ooohboi-steroids' ),
					'bottom left' => __( 'Bottom Left', 'ooohboi-steroids' ),
					'bottom right' => __( 'Bottom Right', 'ooohboi-steroids' ),
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-position: {{VALUE}}; mask-position: {{VALUE}};',
				],
				'condition' => [
					'_ob_steroids_overlay_mask_img[url]!' => '',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE
		$element->add_responsive_control(
			'_ob_steroids_overlay_mask_size',
			[
				'label' => __( 'Mask size', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'initial', 
				'options' => [
					'' => __( 'Default', 'ooohboi-steroids' ),
					'auto' => __( 'Auto', 'ooohboi-steroids' ),
					'cover' => __( 'Cover', 'ooohboi-steroids' ),
					'contain' => __( 'Contain', 'ooohboi-steroids' ),
					'initial' => __( 'Custom', 'ooohboi-steroids' ),
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{VALUE}}; mask-size: {{VALUE}};',
				],
				'condition' => [
					'_ob_steroids_overlay_mask_img[url]!' => '',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE Custom
		$element->add_responsive_control(
			'_ob_steroids_overlay_mask_size_width', 
			[
				'label' => __( 'Width', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
				],
				'condition' => [
					'_ob_steroids_overlay_mask_size' => [ 'initial' ],
					'_ob_steroids_overlay_mask_img[url]!' => '',
				],
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'selectors' => [
							'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_ob_steroids_overlay_mask_size_tablet' => [ 'initial' ],
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'selectors' => [
							'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_ob_steroids_overlay_mask_size_mobile' => [ 'initial' ], 
						],
					],
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ REPEAT
		$element->add_responsive_control(
			'_ob_steroids_overlay_mask_repeat',
			[
				'label' => __( 'Mask repeat', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'no-repeat' => __( 'No-repeat', 'ooohboi-steroids' ),
					'repeat' => __( 'Repeat', 'ooohboi-steroids' ),
					'repeat-x' => __( 'Repeat-x', 'ooohboi-steroids' ),
					'repeat-y' => __( 'Repeat-y', 'ooohboi-steroids' ),
				],
				'selectors' => [
					$selector => '-webkit-mask-repeat: {{VALUE}}; mask-repeat: {{VALUE}};',
				],
				'condition' => [
					'_ob_steroids_overlay_mask_img[url]!' => '',
				],
			]
		);

		$element->end_popover(); // popover MASQ end

		// --------------------------------------------------------------------------------------------- CONTROL Z-INDeX
		$element->add_control(
			'_ob_steroids_overlay_z_index',
			[
				'label' => __( 'Z-Index', 'ooohboi-steroids' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -9999,
				'default' => -1, 
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => 'z-index: {{VALUE}};',
				],
				'label_block' => false,
			]
		);

		$element->end_controls_tab(); // Overlay tab end

		// --------------------------------------------------------------------------------------------- START TAB Underlay ------------------------------- >>>>>

		$element->start_controls_tab(
            '_ob_steroids_tab_underlay',
            [
                'label' => __( 'Underlay', 'ooohboi-steroids' ),
            ]
		);

		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_ob_steroids_underlay_background',
                'selector' => '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after',
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND OPACITY
        $element->add_control(
            '_ob_steroids_underlay_bg_opacity',
            [
                'label' => __( 'Opacity', 'ooohboi-steroids' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.7,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'opacity: {{SIZE}};',
				],
				'condition' => [
                    '_ob_steroids_underlay_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL FILTERS
		$element->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_ob_steroids_underlay_bg_filters',
                'selector' => '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after',
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BLEND MODE
        $element->add_control(
            '_ob_steroids_underlay_bg_blend_mode',
            [
                'label' => __( 'Blend Mode', 'ooohboi-steroids' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'Normal', 'ooohboi-steroids' ),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'mix-blend-mode: {{VALUE}}',
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER W H Y X Rot
		$element->add_control(
			'_ob_steroids_underlay_popover_whyxrot',
			[
				'label' => __( 'Position and Size', 'ooohboi-steroids' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);

		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH
		$element->add_responsive_control(
			'_ob_steroids_underlay_w',
			[
				'label' => __( 'Width', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT
		$element->add_responsive_control(
			'_ob_steroids_underlay_h',
			[
				'label' => __( 'Height', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP
		$element->add_responsive_control(
			'_ob_steroids_underlay_y',
			[
				'label' => __( 'Offset Top', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT
		$element->add_responsive_control(
			'_ob_steroids_underlay_x',
			[
				'label' => __( 'Offset Left', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER ROTATION
		# NOTE : this is the hack. Elementor does not do well with 'deg' when speaking of responsiveness!
		$element->add_responsive_control(
			'_ob_steroids_underlay_rot',
			[
				'label' => __( 'Rotate', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$element->end_popover(); // popover end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER
		$element->add_control(
			'_ob_steroids_underlay_popover_border',
			[
				'label' => __( 'Border', 'ooohboi-steroids' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);

		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER ALL
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_ob_steroids_underlay_borders', 
				'label' => __( 'Border', 'ooohboi-steroids' ), 
				'selector' => '{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after', 
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER RADIUS
		$element->add_responsive_control(
			'_ob_steroids_underlay_border_rad',
			[
				'label' => __( 'Border Radius', 'ooohboi-steroids' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$element->end_popover(); // popover BORdER end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ - UNDERLAY ------------------->>
		$element->add_control(
            '_ob_steroids_underlay_popover_masq',
            [
                'label' => __( 'Underlay Mask', 'ooohboi-steroids' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'_ob_steroids_underlay_background_background' => [ 'classic', 'gradient' ], 
				],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ IMAGE
		$element->add_responsive_control(
			'_ob_steroids_underlay_mask_img',
			[
				'label' => __( 'Choose Image Mask', 'ooohboi-steroids' ),
				'description' => __( 'NOTE: Image Mask should be black-and-transparent SVG file! Anything that’s 100% black in the image mask with be completely visible, anything that’s transparent will be completely hidden.', 'ooohboi-steroids' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-image: url("{{URL}}"); mask-image: url("{{URL}}"); -webkit-mask-mode: alpha; mask-mode: alpha;',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ POSITION
		$element->add_responsive_control(
			'_ob_steroids_underlay_mask_position',
			[
				'label' => __( 'Mask position', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'initial',
				'options' => [
					'' => __( 'Default', 'ooohboi-steroids' ),
					'center center' => __( 'Center Center', 'ooohboi-steroids' ),
					'center left' => __( 'Center Left', 'ooohboi-steroids' ),
					'center right' => __( 'Center Right', 'ooohboi-steroids' ),
					'top center' => __( 'Top Center', 'ooohboi-steroids' ),
					'top left' => __( 'Top Left', 'ooohboi-steroids' ),
					'top right' => __( 'Top Right', 'ooohboi-steroids' ),
					'bottom center' => __( 'Bottom Center', 'ooohboi-steroids' ),
					'bottom left' => __( 'Bottom Left', 'ooohboi-steroids' ),
					'bottom right' => __( 'Bottom Right', 'ooohboi-steroids' ),
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-position: {{VALUE}}; mask-position: {{VALUE}};',
				],
				'condition' => [
					'_ob_steroids_underlay_mask_img[url]!' => '',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE
		$element->add_responsive_control(
			'_ob_steroids_underlay_mask_size',
			[
				'label' => __( 'Mask size', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'initial', 
				'options' => [
					'' => __( 'Default', 'ooohboi-steroids' ),
					'auto' => __( 'Auto', 'ooohboi-steroids' ),
					'cover' => __( 'Cover', 'ooohboi-steroids' ),
					'contain' => __( 'Contain', 'ooohboi-steroids' ),
					'initial' => __( 'Custom', 'ooohboi-steroids' ),
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{VALUE}}; mask-size: {{VALUE}};',
				],
				'condition' => [
					'_ob_steroids_underlay_mask_img[url]!' => '',
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE Custom
		$element->add_responsive_control(
			'_ob_steroids_underlay_mask_size_width', 
			[
				'label' => __( 'Width', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
				],
				'condition' => [
					'_ob_steroids_underlay_mask_size' => [ 'initial' ],
					'_ob_steroids_underlay_mask_img[url]!' => '',
				],
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'selectors' => [
							'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_ob_steroids_underlay_mask_size_tablet' => [ 'initial' ],
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'selectors' => [
							'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:before' => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_ob_steroids_underlay_mask_size_mobile' => [ 'initial' ], 
						],
					],
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ REPEAT
		$element->add_responsive_control(
			'_ob_steroids_underlay_mask_repeat',
			[
				'label' => __( 'Mask repeat', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'no-repeat' => __( 'No-repeat', 'ooohboi-steroids' ),
					'repeat' => __( 'Repeat', 'ooohboi-steroids' ),
					'repeat-x' => __( 'Repeat-x', 'ooohboi-steroids' ),
					'repeat-y' => __( 'Repeat-y', 'ooohboi-steroids' ),
				],
				'selectors' => [
					$selector => '-webkit-mask-repeat: {{VALUE}}; mask-repeat: {{VALUE}};',
				],
				'condition' => [
					'_ob_steroids_underlay_mask_img[url]!' => '',
				],
			]
		);

		$element->end_popover(); // popover MASQ end

		// --------------------------------------------------------------------------------------------- CONTROL Z-INDeX
		$element->add_control(
			'_ob_steroids_underlay_z_index',
			[
				'label' => __( 'Z-Index', 'ooohboi-steroids' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -9999,
				'default' => -1, 
				'selectors' => [
					'{{WRAPPER}}.ob-has-background-overlay > .elementor-widget-container:after' => 'z-index: {{VALUE}};',
				],
				'label_block' => false,
			]
		);

		$element->end_controls_tab(); // Underlay tab end

		$element->end_controls_tabs(); // Underlay and Overlay tabs end

		$element->end_controls_section(); // END SECTION / PANEL

	}

    public function poopart_remove_horizontal_scroller( \Elementor\Core\DocumentTypes\PageBase $page ) {

		// ------------------------------------------------------------------------- CONTROL: get rid of horizontal scroller
		$page->add_control(
			'_ob_steroids_no_horizontal_scroller',
			[
				'label' => __( 'Get rid of the Horizontal scroller?', 'ooohboi-steroids' ),
				'description' => __( 'OoohBoi POOOPART may cause Horizontal Scroller to show up. This is how you can remove it.', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'ooohboi-steroids' ),
				'label_off' => __( 'No', 'ooohboi-steroids' ),
				'return_value' => 'yes',
				'default' => 'no',
				'selectors' => [
					'html, body' => 'overflow-x: hidden;',
				],
				'label_block' => false,
				'separator' => 'before', 
			]
		);	

	}

}