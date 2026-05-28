<?php
/**
 * Luxury homepage — premium takeaway (pickup only).
 *
 * @package Curry_Leaves_Co
 */

get_header('luxury');

$sections = array(
	'hero',
	'experience',
	'dishes',
	'top-dishes',
	'specials',
	'veg-dishes',
	'testimonials',
	'gallery',
	'order',
);

foreach ($sections as $section) {
	get_template_part('template-parts/home/' . $section);
}

get_footer('luxury');
