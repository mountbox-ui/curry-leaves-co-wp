<?php get_header(); ?>

    <main id="primary" class="site-main max-w-7xl min-h-[70vh] mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-12' ); ?>>
                    <header class="mb-6">
                        <?php the_title( '<h2 class="text-3xl font-bold mb-2">', '</h2>' ); ?>
                    </header>
                    <div class="prose max-w-none">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
            the_posts_navigation();
        else :
            ?>
            <p class="paragraph">No content found.</p>
            <?php
        endif;
        ?>
    </main>

<?php get_footer(); ?>
