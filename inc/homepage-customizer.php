<?php
/**
 * WordPress Customizer — editable homepage content.
 *
 * @package Curry_Leaves_Co
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register homepage customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function clc_homepage_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'clc_homepage',
		array(
			'title'       => __( 'Luxury Homepage', 'curry-leaves-co' ),
			'description' => __( 'Edit hero slides, contact details, and section content. Pickup-only takeaway — no dining or delivery.', 'curry-leaves-co' ),
			'priority'    => 30,
		)
	);

	/* Contact */
	$wp_customize->add_section(
		'clc_contact',
		array(
			'title' => __( 'Contact & Order', 'curry-leaves-co' ),
			'panel' => 'clc_homepage',
		)
	);

	$contact_fields = array(
		'clc_phone'   => array( 'label' => __( 'Phone', 'curry-leaves-co' ), 'default' => '+64 9 123 4567' ),
		'clc_email'   => array( 'label' => __( 'Email', 'curry-leaves-co' ), 'default' => 'hello@curryleaves.co.nz' ),
		'clc_address' => array( 'label' => __( 'Address', 'curry-leaves-co' ), 'default' => '123 Queen Street, Auckland, New Zealand' ),
		'clc_hours'   => array( 'label' => __( 'Opening Hours', 'curry-leaves-co' ), 'default' => "Mon–Fri: 11am – 9pm\nSat–Sun: 10am – 10pm" ),
	);

	foreach ( $contact_fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'clc_contact',
				'type'    => 'text',
			)
		);
	}

	/* Stats */
	$wp_customize->add_section(
		'clc_stats',
		array(
			'title' => __( 'Experience Stats', 'curry-leaves-co' ),
			'panel' => 'clc_homepage',
		)
	);

	for ( $s = 1; $s <= 3; $s++ ) {
		$wp_customize->add_setting( "clc_stat_{$s}_number", array( 'default' => array( '15+', '50+', '10k+' )[ $s - 1 ], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "clc_stat_{$s}_number", array( 'label' => sprintf( __( 'Stat %d Number', 'curry-leaves-co' ), $s ), 'section' => 'clc_stats', 'type' => 'text' ) );
		$wp_customize->add_setting( "clc_stat_{$s}_label", array( 'default' => array( 'Years Experience', 'Signature Dishes', 'Happy Customers' )[ $s - 1 ], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "clc_stat_{$s}_label", array( 'label' => sprintf( __( 'Stat %d Label', 'curry-leaves-co' ), $s ), 'section' => 'clc_stats', 'type' => 'text' ) );
	}

	/* Hero slides */
	$wp_customize->add_section(
		'clc_hero',
		array(
			'title' => __( 'Hero Slider', 'curry-leaves-co' ),
			'panel' => 'clc_homepage',
		)
	);

	for ( $i = 1; $i <= 5; $i++ ) {
		$wp_customize->add_setting( "clc_hero_{$i}_enabled", array( 'default' => $i <= 3 ? '1' : '0', 'sanitize_callback' => 'clc_sanitize_checkbox' ) );
		$wp_customize->add_control( "clc_hero_{$i}_enabled", array( 'label' => sprintf( __( 'Enable Slide %d', 'curry-leaves-co' ), $i ), 'section' => 'clc_hero', 'type' => 'checkbox' ) );

		$text_fields = array(
			"clc_hero_{$i}_title"    => __( 'Title (HTML allowed: <em>)', 'curry-leaves-co' ),
			"clc_hero_{$i}_subtitle" => __( 'Subtitle', 'curry-leaves-co' ),
			"clc_hero_{$i}_desc"     => __( 'Description', 'curry-leaves-co' ),
			"clc_hero_{$i}_cta1"     => __( 'Primary CTA Text', 'curry-leaves-co' ),
			"clc_hero_{$i}_cta1_url" => __( 'Primary CTA URL', 'curry-leaves-co' ),
			"clc_hero_{$i}_cta2"     => __( 'Secondary CTA Text', 'curry-leaves-co' ),
			"clc_hero_{$i}_cta2_url" => __( 'Secondary CTA URL', 'curry-leaves-co' ),
		);

		foreach ( $text_fields as $key => $label ) {
			$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => 'clc_sanitize_hero_text' ) );
			$wp_customize->add_control( $key, array( 'label' => sprintf( __( 'Slide %d — %s', 'curry-leaves-co' ), $i, $label ), 'section' => 'clc_hero', 'type' => 'text' ) );
		}

		$wp_customize->add_setting( "clc_hero_{$i}_image", array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		if ( class_exists( 'WP_Customize_Media_Control' ) ) {
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					"clc_hero_{$i}_image",
					array(
						'label'     => sprintf( __( 'Slide %d Background Image', 'curry-leaves-co' ), $i ),
						'section'   => 'clc_hero',
						'mime_type' => 'image',
					)
				)
			);
		}
	}

	/* Chef's special */
	$wp_customize->add_section(
		'clc_chef_special',
		array(
			'title' => __( "Chef's Selection", 'curry-leaves-co' ),
			'panel' => 'clc_homepage',
		)
	);

	$chef_fields = array(
		'clc_chef_name'           => array(
			'label'   => __( 'Chef Name', 'curry-leaves-co' ),
			'default' => 'Chef Arjun Mehta',
			'type'    => 'text',
		),
		'clc_chef_title'          => array(
			'label'   => __( 'Chef Title', 'curry-leaves-co' ),
			'default' => 'Executive Chef',
			'type'    => 'text',
		),
		'clc_special_month_title' => array(
			'label'   => __( 'Badge Label', 'curry-leaves-co' ),
			'default' => 'Dish of the Month',
			'type'    => 'text',
		),
		'clc_special_heading'     => array(
			'label'   => __( 'Dish Title (HTML: <em>)', 'curry-leaves-co' ),
			'default' => 'Truffle-Infused <em>Beef Wellington</em>',
			'type'    => 'text',
		),
		'clc_special_story'       => array(
			'label'   => __( 'Chef Story / Description', 'curry-leaves-co' ),
			'default' => 'Our executive chef layers buttery pastry with premium grass-fed beef, black truffle, and a red wine reduction — composed for takeaway and finished moments before you collect.',
			'type'    => 'textarea',
		),
		'clc_special_price'       => array(
			'label'   => __( 'Price (numbers only)', 'curry-leaves-co' ),
			'default' => '58',
			'type'    => 'text',
		),
	);

	foreach ( $chef_fields as $id => $field ) {
		$sanitize = ( 'textarea' === $field['type'] ) ? 'sanitize_textarea_field' : ( false !== strpos( $id, 'heading' ) ? 'clc_sanitize_hero_text' : 'sanitize_text_field' );
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'clc_chef_special',
				'type'    => $field['type'],
			)
		);
	}

	$wp_customize->add_setting( 'clc_special_image', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	if ( class_exists( 'WP_Customize_Media_Control' ) ) {
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'clc_special_image',
				array(
					'label'     => __( 'Dish Image', 'curry-leaves-co' ),
					'section'   => 'clc_chef_special',
					'mime_type' => 'image',
				)
			)
		);
	}

	/* Section headings */
	$wp_customize->add_section(
		'clc_headings',
		array(
			'title' => __( 'Section Headings', 'curry-leaves-co' ),
			'panel' => 'clc_homepage',
		)
	);

	$headings = array(
		'clc_about_title' => array( 'default' => 'A Signature <em>Takeaway</em> Experience', 'label' => __( 'About Section Title', 'curry-leaves-co' ) ),
		'clc_menu_title'  => array( 'default' => 'Favourite <em>Dishes</em>', 'label' => __( 'Menu Section Title', 'curry-leaves-co' ) ),
	);

	foreach ( $headings as $id => $h ) {
		$wp_customize->add_setting( $id, array( 'default' => $h['default'], 'sanitize_callback' => 'clc_sanitize_hero_text' ) );
		$wp_customize->add_control( $id, array( 'label' => $h['label'], 'section' => 'clc_headings', 'type' => 'text' ) );
	}

	$wp_customize->add_setting( 'clc_footer_text', array(
		'default'           => 'Pickup-only gourmet takeaway. No dining, no delivery — exceptional flavours crafted for collection.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'clc_footer_text', array(
		'label'   => __( 'Footer Description', 'curry-leaves-co' ),
		'section' => 'clc_contact',
		'type'    => 'textarea',
	) );
}
add_action( 'customize_register', 'clc_homepage_customize_register' );

/**
 * Checkbox sanitizer.
 *
 * @param mixed $checked Value.
 * @return string
 */
function clc_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && ( true === $checked || '1' === $checked || 1 === $checked ) ) ? '1' : '0';
}

/**
 * Allow limited HTML in hero titles.
 *
 * @param string $text Input.
 * @return string
 */
function clc_sanitize_hero_text( $text ) {
	return wp_kses( $text, array( 'em' => array(), 'br' => array(), 'span' => array() ) );
}
