<?php

/**
 * Function to register control and setting
 */
function themename_register_option( $wp_customize, $option ) {

	// Initialize Setting.
	$wp_customize->add_setting( $option['name'], array(
		'sanitize_callback'  => $option['sanitize_callback'],
		'default'            => isset( $option['default'] ) ? $option['default'] : '',
		'transport'          => isset( $option['transport'] ) ? $option['transport'] : 'refresh',
		'theme_supports'     => isset( $option['theme_supports'] ) ? $option['theme_supports'] : '',
		'description_hidden' => isset( $option['description_hidden'] ) ? $option['description_hidden'] : 0,
	) );

	$control = array(
		'label'    => $option['label'],
		'section'  => $option['section'],
		'settings' => $option['name'],
	);

	if ( isset( $option['active_callback'] ) ) {
		$control['active_callback'] = $option['active_callback'];
	}

	if ( isset( $option['priority'] ) ) {
		$control['priority'] = $option['priority'];
	}

	if ( isset( $option['choices'] ) ) {
		$control['choices'] = $option['choices'];
	}

	if ( isset( $option['type'] ) ) {
		$control['type'] = $option['type'];
	}

	if ( isset( $option['input_attrs'] ) ) {
		$control['input_attrs'] = $option['input_attrs'];
	}

	if ( isset( $option['description'] ) ) {
		$control['description'] = $option['description'];
	}

	if ( isset( $option['custom_control'] ) ) {
		$wp_customize->add_control( new $option['custom_control']( $wp_customize, $option['name'], $control ) );
	} else {
		$wp_customize->add_control( $option['name'], $control );
	}
}

/**
 * Alphabetically sort theme options sections
 *
 * @param  wp_customize object $wp_customize wp_customize object.
 */
function themename_sort_sections_list( $wp_customize ) {
	foreach ( $wp_customize->sections() as $section_key => $section_object ) {
		if ( false !== strpos( $section_key, 'themename_' ) && 'themename_important_links' !== $section_key ) {
			$options[] = $section_key;
		}
	}

	sort( $options );

	$priority = 1;
	foreach ( $options as  $option ) {
		$wp_customize->get_section( $option )->priority = $priority++;
	}
}
add_action( 'customize_register', 'themename_sort_sections_list', 99 );

/**
 * Returns an array of visibility options for featured sections
 *
 * @since 1.0
 */
function themename_section_visibility_options() {
	$options = array(
		'homepage'    => esc_html__( 'Homepage / Frontpage', 'themename' ),
		'entire-site' => esc_html__( 'Entire Site', 'themename' ),
		'disabled'    => esc_html__( 'Disabled', 'themename' ),
	);

	return apply_filters( 'themename_section_visibility_options', $options );
}

/**
 * Returns an array of featured content options
 *
 * @since 1.0
 */
function themename_sections_layout_options() {
	$options = array(
		'layout-one'   => esc_html__( '1 column', 'themename' ),
		'layout-two'   => esc_html__( '2 columns', 'themename' ),
		'layout-three' => esc_html__( '3 columns', 'themename' ),
		'layout-four'  => esc_html__( '4 columns', 'themename' ),
	);

	return apply_filters( 'themename_sections_layout_options', $options );
}

/**
 * Returns an array of section types
 *
 * @since 1.0
 */
function themename_section_type_options() {
	$options = array(
		'post'     => esc_html__( 'Post', 'themename' ),
		'page'     => esc_html__( 'Page', 'themename' ),
		'category' => esc_html__( 'Category', 'themename' ),
		'custom'   => esc_html__( 'Custom', 'themename' ),
	);

	return apply_filters( 'themename_section_type_options', $options );
}

/**
 * Returns an array of color schemes registered for catchresponsive.
 *
 * @since 1.0
 */
function themename_get_pagination_types() {
	$pagination_types = array(
		'default' => esc_html__( 'Default(Older Posts/Newer Posts)', 'themename' ),
		'numeric' => esc_html__( 'Numeric', 'themename' ),
	);

	return apply_filters( 'themename_get_pagination_types', $pagination_types );
}

/**
 * Generate a list of all available post array
 *
 * @param  string $post_type post type.
 * @return post_array
 */
function themename_generate_post_array( $post_type = 'post' ) {
	$output = array();
	$posts = get_posts( array(
		'post_type'        => $post_type,
		'post_status'      => 'publish',
		'suppress_filters' => false,
		'posts_per_page'   => -1,
		)
	);

	$output['0']= esc_html__( '-- Select --', 'themename' );

	foreach ( $posts as $post ) {
		$output[ $post->ID ] = ! empty( $post->post_title ) ? $post->post_title : sprintf( __( '#%d (no title)', 'themename' ), $post->ID );
	}

	return $output;
}

if ( ! function_exists( 'themename_get_default_sections_value' ) ) :
	/**
	 * Returns default sections value
	 */
	function themename_get_default_sections_value() {
		$sections = themename_get_sortable_sections();
		$value    = array_keys( $sections );
		$value    = implode( ',', $value );

		return $value;
	}
endif;

/**
 * Returns an array of feature slider transition effects
 *
 * @since 1.0
 */
function themename_transition_effects() {
	$options = array(
		'default'            => 'default',
		'bounce'             => 'bounce',
		'flash'              => 'flash',
		'pulse'              => 'pulse',
		'rubberBand'         => 'rubberBand',
		'shake'              => 'shake',
		'headShake'          => 'headShake',
		'swing'              => 'swing',
		'tada'               => 'tada',
		'wobble'             => 'wobble',
		'jello'              => 'jello',
		'bounceIn'           => 'bounceIn',
		'bounceInDown'       => 'bounceInDown',
		'bounceInLeft'       => 'bounceInLeft',
		'bounceInRight'      => 'bounceInRight',
		'bounceInUp'         => 'bounceInUp',
		'bounceOut'          => 'bounceOut',
		'bounceOutDown'      => 'bounceOutDown',
		'bounceOutLeft'      => 'bounceOutLeft',
		'bounceOutRight'     => 'bounceOutRight',
		'bounceOutUp'        => 'bounceOutUp',
		'fadeIn'             => 'fadeIn',
		'fadeInDown'         => 'fadeInDown',
		'fadeInDownBig'      => 'fadeInDownBig',
		'fadeInLeft'         => 'fadeInLeft',
		'fadeInLeftBig'      => 'fadeInLeftBig',
		'fadeInRight'        => 'fadeInRight',
		'fadeInRightBig'     => 'fadeInRightBig',
		'fadeInUp'           => 'fadeInUp',
		'fadeInUpBig'        => 'fadeInUpBig',
		'fadeOut'            => 'fadeOut',
		'fadeOutDown'        => 'fadeOutDown',
		'fadeOutDownBig'     => 'fadeOutDownBig',
		'fadeOutLeft'        => 'fadeOutLeft',
		'fadeOutLeftBig'     => 'fadeOutLeftBig',
		'fadeOutRight'       => 'fadeOutRight',
		'fadeOutRightBig'    => 'fadeOutRightBig',
		'fadeOutUp'          => 'fadeOutUp',
		'fadeOutUpBig'       => 'fadeOutUpBig',
		'flipInX'            => 'flipInX',
		'flipInY'            => 'flipInY',
		'flipOutX'           => 'flipOutX',
		'flipOutY'           => 'flipOutY',
		'lightSpeedIn'       => 'lightSpeedIn',
		'lightSpeedOut'      => 'lightSpeedOut',
		'rotateIn'           => 'rotateIn',
		'rotateInDownLeft'   => 'rotateInDownLeft',
		'rotateInDownRight'  => 'rotateInDownRight',
		'rotateInUpLeft'     => 'rotateInUpLeft',
		'rotateInUpRight'    => 'rotateInUpRight',
		'rotateOut'          => 'rotateOut',
		'rotateOutDownLeft'  => 'rotateOutDownLeft',
		'rotateOutDownRight' => 'rotateOutDownRight',
		'rotateOutUpLeft'    => 'rotateOutUpLeft',
		'rotateOutUpRight'   => 'rotateOutUpRight',
		'hinge'              => 'hinge',
		'jackInTheBox'       => 'jackInTheBox',
		'rollIn'             => 'rollIn',
		'rollOut'            => 'rollOut',
		'zoomIn'             => 'zoomIn',
		'zoomInDown'         => 'zoomInDown',
		'zoomInLeft'         => 'zoomInLeft',
		'zoomInRight'        => 'zoomInRight',
		'zoomInUp'           => 'zoomInUp',
		'zoomOut'            => 'zoomOut',
		'zoomOutDown'        => 'zoomOutDown',
		'zoomOutLeft'        => 'zoomOutLeft',
		'zoomOutRight'       => 'zoomOutRight',
		'zoomOutUp'          => 'zoomOutUp',
		'slideInDown'        => 'slideInDown',
		'slideInLeft'        => 'slideInLeft',
		'slideInRight'       => 'slideInRight',
		'slideInUp'          => 'slideInUp',
		'slideOutDown'       => 'slideOutDown',
		'slideOutLeft'       => 'slideOutLeft',
		'slideOutRight'      => 'slideOutRight',
		'slideOutUp'         => 'slideOutUp',
		'heartBeat'          => 'heartBeat',
	);

	return apply_filters( 'themename_transition_effects', $options );
}


/**
 * Returns an array of featured content show registered
 *
 * @since 1.0
 */
function themename_content_show() {
	$options = array(
		'excerpt'      => esc_html__( 'Show Excerpt', 'themename' ),
		'full-content' => esc_html__( 'Full Content', 'themename' ),
		'hide-content' => esc_html__( 'Hide Content', 'themename' ),
	);
	return apply_filters( 'themename_content_show', $options );
}


/**
 * Returns an array of featured content show registered
 *
 * @since 1.0
 */
function themename_meta_show() {
	$options = array(
		'show-meta' => esc_html__( 'Show Meta', 'themename' ),
		'hide-meta' => esc_html__( 'Hide Meta', 'themename' ),
	);
	return apply_filters( 'themename_meta_show', $options );
}
