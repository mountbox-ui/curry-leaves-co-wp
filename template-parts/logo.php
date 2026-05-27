<?php
/**
 * Site logo markup.
 *
 * @package Curry_Leaves_Co
 *
 * @var array $args Template arguments.
 */

$show_tagline = ! empty( $args['show_tagline'] );
$tagline      = isset( $args['tagline'] ) ? $args['tagline'] : __( 'Takeaway · NZ', 'curry-leaves-co' );
$height       = isset( $args['height'] ) ? (int) $args['height'] : 48;
$class        = isset( $args['class'] ) ? $args['class'] : 'site-logo';

clc_the_logo(
	array(
		'class'        => $class,
		'height'       => $height,
		'show_tagline' => $show_tagline,
		'tagline'      => $tagline,
	)
);
