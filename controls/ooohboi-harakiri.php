<?php
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main OoohBoi Harakiri
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class OoohBoi_Harakiri {

	/**
	 * Initialize 
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public static function init() {

		add_action( 'elementor/element/heading/section_title_style/before_section_end',  [ __CLASS__, 'add_section' ] );
        add_action( 'elementor/element/text-editor/section_style/before_section_end',  [ __CLASS__, 'add_section' ] );
        add_action( 'elementor/element/after_add_attributes',  [ __CLASS__, 'add_attributes' ] );

    }

    public static function add_attributes( Element_Base $element ) {

        if( ! in_array( $element->get_name(), [ 'heading', 'text-editor' ] ) ) return;
		$settings = $element->get_settings();
        $does_harakiri = isset( $settings[ '_ob_harakiri_writing_mode' ] ) ? $settings[ '_ob_harakiri_writing_mode' ] : '';
        
        if( 'vertical-lr' === $does_harakiri || 'vertical-rl' === $does_harakiri ) 
            $element->add_render_attribute( '_wrapper', 'class', 'ob-harakiri' );

    }
    
	public static function add_section( Element_Base $element ) {

		//  create panel section
		$element->add_control(
			'_ob_harakiri_plugin_title',
			[
				'label' => 'H A R A K I R I', 
				'type' => Controls_Manager::HEADING,
				'separator' => 'before', 
			]
        );
        $element->add_responsive_control(
			'_ob_harakiri_writing_mode',
			[
				'label' => __( 'Writing Mode', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
                'default' => 'inherit', 
                'prefix_class' => 'ob-harakiri-', 
				'options' => [
					'vertical-lr' => __( 'Vertical LR', 'ooohboi-steroids' ),
					'vertical-rl' => __( 'Vertical RL', 'ooohboi-steroids' ),
					'inherit' => __( 'Normal', 'ooohboi-steroids' ),
                ],
				'selectors' => [
                    '{{WRAPPER}}.ob-harakiri .elementor-heading-title' => 'writing-mode: {{VALUE}};', 
                    '{{WRAPPER}}.ob-harakiri .elementor-text-editor' => 'writing-mode: {{VALUE}};',
                ],
			]
        );
        $element->add_responsive_control(
			'_ob_harakiri_make_inline',
			[
				'label' => __( 'Flip', 'ooohboi-steroids' ), 
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'ooohboi-steroids' ),
				'label_off' => __( 'No', 'ooohboi-steroids' ),
				'return_value' => 'no',
				'default' => 'no',
                'label_block' => false,
                'condition' => [
					'_ob_harakiri_writing_mode!' => 'inherit', 
                ],
                'selectors' => [
                    '{{WRAPPER}}.ob-harakiri .elementor-heading-title' => 'transform: rotate(180deg);', 
                    '{{WRAPPER}}.ob-harakiri .elementor-text-editor' => 'transform: rotate(180deg);',
                ],
                'device_args' => [
                    Controls_Stack::RESPONSIVE_TABLET => [
                        'selectors' => [
                            '{{WRAPPER}}.ob-harakiri .elementor-heading-title' => 'transform: rotate(180deg);', 
                            '{{WRAPPER}}.ob-harakiri .elementor-text-editor' => 'transform: rotate(180deg);',
                        ],
                        'condition' => [
                            '_ob_harakiri_writing_mode_tablet!' => 'inherit', 
                        ],
                    ],
                    Controls_Stack::RESPONSIVE_MOBILE => [
                        'selectors' => [
                            '{{WRAPPER}}.ob-harakiri .elementor-heading-title' => 'transform: rotate(180deg);', 
                            '{{WRAPPER}}.ob-harakiri .elementor-text-editor' => 'transform: rotate(180deg);',
                        ],
                        'condition' => [
                            '_ob_harakiri_writing_mode_mobile!' => 'inherit', 
                        ],
                    ],
                ],
			]
        );
        $element->add_responsive_control(
			'_ob_harakiri_width',
			[
				'label' => __( 'Width', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SELECT,
                'default' => '', 
				'options' => [
					'' => __( 'Default', 'ooohboi-steroids' ),
					'inherit' => __( 'Full Width', 'ooohboi-steroids' ) . ' (100%)',
					'auto' => __( 'Inline', 'ooohboi-steroids' ) . ' (auto)', 
					'initial' => __( 'Custom', 'ooohboi-steroids' ),
				],
				'selectors_dictionary' => [
					'inherit' => '100%',
				],
				'selectors' => [
					'{{WRAPPER}}.ob-harakiri' => 'width: {{VALUE}}; max-width: {{VALUE}};',
                ],
			]
		);
        $element->add_responsive_control(
			'_ob_harakiri_width_custom',
			[
				'label' => __( 'Custom Width', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'max' => 100,
						'step' => 1,
					],
                ],
                'default' => [
					'unit' => '%',
					'size' => 100,
                ],
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}}.ob-harakiri' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
                'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'condition' => [
							'_ob_harakiri_width_tablet' => [ 'initial' ],
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'condition' => [
                            '_ob_harakiri_width_mobile' => [ 'initial' ], 
						],
					],
				],
                'condition' => [
					'_ob_harakiri_width' => [ 'initial' ],
				],
			]
		);
		$element->add_responsive_control(
			'_ob_harakiri_max_height',
			[
				'label' => __( 'Set max-height', 'ooohboi-steroids' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'em' => [
						'min' => 1,
						'max' => 100,
                    ],
                    'vh' => [
						'min' => 1,
						'max' => 100,
					],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ob-harakiri .elementor-heading-title' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};', 
                    '{{WRAPPER}}.ob-harakiri .elementor-text-editor' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
                ],
                'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'condition' => [
							'_ob_harakiri_width_tablet!' => [ '' ],
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'condition' => [
							'_ob_harakiri_width_mobile!' => [ '' ], 
						],
					],
				],
                'condition' => [
					'_ob_harakiri_width!' => [ '' ],
                ],
			]
		);

	}

}