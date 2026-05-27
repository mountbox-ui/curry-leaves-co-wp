<?php
/**
 * Hero slider section.
 *
 * @package Curry_Leaves_Co
 */

$slides = clc_get_hero_slides();
if ( empty( $slides ) ) {
	return;
}
?>
<section class="hero-section" id="home" aria-label="<?php esc_attr_e( 'Hero', 'curry-leaves-co' ); ?>">
	<div class="hero-particles" aria-hidden="true"></div>
	<div class="hero-slider">
		<?php foreach ( $slides as $index => $slide ) : ?>
			<div class="hero-slide<?php echo 0 === $index ? ' active' : ''; ?>" data-slide="<?php echo esc_attr( (string) $index ); ?>">
				<div class="hero-slide-bg" style="background-image: url('<?php echo esc_url( $slide['image'] ); ?>');" role="img" aria-label="<?php echo esc_attr( wp_strip_all_tags( $slide['subtitle'] ) ); ?>"></div>
				<div class="hero-overlay"></div>
				<div class="hero-content-wrap">
					<div class="hero-content">
						<span class="hero-subtitle"><?php echo esc_html( $slide['subtitle'] ); ?></span>
						<h1 class="hero-title"><?php echo wp_kses_post( $slide['title'] ); ?></h1>
						<p class="hero-description"><?php echo esc_html( $slide['desc'] ); ?></p>
						<div class="hero-cta">
							<a href="<?php echo esc_url( $slide['cta1_url'] ); ?>" class="btn-luxury btn-gold"><?php echo esc_html( $slide['cta1'] ); ?></a>
							<a href="<?php echo esc_url( $slide['cta2_url'] ); ?>" class="btn-luxury btn-outline"><?php echo esc_html( $slide['cta2'] ); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if ( count( $slides ) > 1 ) : ?>
		<div class="hero-dots" role="tablist" aria-label="<?php esc_attr_e( 'Hero slides', 'curry-leaves-co' ); ?>">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<button type="button" class="hero-dot<?php echo 0 === $index ? ' active' : ''; ?>" data-slide="<?php echo esc_attr( (string) $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'curry-leaves-co' ), $index + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<a href="#about" class="scroll-indicator" aria-label="<?php esc_attr_e( 'Scroll down', 'curry-leaves-co' ); ?>">
		<span><?php esc_html_e( 'Scroll', 'curry-leaves-co' ); ?></span>
		<div class="scroll-line"></div>
	</a>
</section>
