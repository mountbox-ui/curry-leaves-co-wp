<?php
/**
 * The template for displaying single menu items
 */

get_header();
?>

<div class="min-h-screen bg-gray-50/50">
    <?php
    while (have_posts()):
        the_post();
        $price = get_post_meta(get_the_ID(), '_menu_item_price', true);
        $discount = get_post_meta(get_the_ID(), '_menu_item_discount_percentage', true);
        $offer_amount = get_post_meta(get_the_ID(), '_menu_item_offer_amount', true);
        $has_discount = $discount && floatval($discount) > 0 && $offer_amount !== '';
        $final_price = $price;
        if ($has_discount) {
            $final_price = number_format_i18n(max(0, floatval($price) - floatval($offer_amount)), 2);
        }
        ?>

        <!-- Hero Section with Image -->
        <div class="relative h-[60vh] md:h-[70vh] w-full overflow-hidden">
            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>

            <div class="absolute top-8 left-8 z-20">
                <a href="<?php echo esc_url(home_url('/menu/')); ?>"
                    class="group flex items-center gap-3 bg-white/20 backdrop-blur-xl border border-white/30 px-6 py-3 rounded-2xl text-white font-bold hover:bg-white/40 transition-all shadow-2xl">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Menu
                </a>
            </div>

            <div class="absolute bottom-12 left-0 w-full z-10">
                <div class="max-w-7xl mx-auto px-6 md:px-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div class="max-w-3xl">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="bg-orange-500 text-white px-4 py-1 rounded-full text-sm font-black uppercase tracking-widest shadow-lg">
                                Rating</div>
                            <div
                                class="flex items-center gap-1.5 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-white border border-white/20">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <span class="font-bold text-sm"><?php echo esc_html($rating); ?></span>
                            </div>
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black text-white mb-2 leading-none drop-shadow-2xl">
                            <?php the_title(); ?></h1>
                    </div>
                    <?php if ($price): ?>
                        <div
                            class="bg-white/10 backdrop-blur-2xl border border-white/20 p-6 rounded-3xl text-center min-w-[200px] shadow-2xl">
                            <div class="text-white/60 text-xs font-bold uppercase tracking-widest mb-1">Price</div>
                            <?php if ($has_discount): ?>
                                <div class="text-sm line-through text-white/60">$<?php echo esc_html(number_format_i18n(floatval($price), 2)); ?></div>
                            <?php endif; ?>
                            <div class="text-4xl font-black text-orange-400">$<?php echo esc_html($final_price); ?></div>
                            <?php if ($has_discount): ?>
                                <div class="text-sm font-semibold text-emerald-200 mt-2"><?php echo esc_html($discount); ?>% off</div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Detailed Info -->
        <div class="max-w-7xl mx-auto px-6 md:px-12 -mt-8 relative z-20 pb-24">
            <div
                class="bg-white rounded-[40px] shadow-2xl border border-gray-100 p-8 md:p-16 flex flex-col lg:flex-row gap-16">

                <!-- Left: Content & Ingredients -->
                <div class="lg:w-2/3">
                    <div class="prose prose-2xl prose-orange max-w-none mb-16">
                        <h2 class="text-3xl font-black text-gray-900 mb-8 border-l-8 border-orange-500 pl-6">The Dish Story
                        </h2>
                        <div class="text-gray-600 leading-relaxed font-medium italic">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php if ($ingredients): ?>
                        <div>
                            <h2 class="text-3xl font-black text-gray-900 mb-8 border-l-8 border-orange-500 pl-6">Key Ingredients
                            </h2>
                            <div class="flex flex-wrap gap-3">
                                <?php
                                $ing_list = explode(',', $ingredients);
                                foreach ($ing_list as $ing):
                                    ?>
                                    <span
                                        class="bg-gray-50 border border-gray-200 px-6 py-3 rounded-2xl text-gray-700 font-bold hover:bg-orange-50 hover:border-orange-200 transition-colors cursor-default">
                                        <?php echo esc_html(trim($ing)); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Action Card -->
                <div class="lg:w-1/3">
                    <div class="sticky top-32 bg-gray-50 rounded-3xl p-8 border border-gray-100">
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Ready to taste?</h3>
                            <p class="text-gray-500 text-sm">Experience authentic flavors crafted with fresh ingredients and
                                traditional techniques.</p>
                        </div>

                        <div class="space-y-4">
                            <button
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black py-5 px-8 rounded-2xl transition-all shadow-xl shadow-orange-200 text-xl flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Add to Cart
                            </button>
                            <button
                                class="w-full bg-white border-2 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-black py-5 px-8 rounded-2xl transition-all text-xl">
                                Order Now
                            </button>
                        </div>

                        <div class="mt-8 pt-8 border-t border-gray-200 grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-orange-600 font-black text-lg mb-0.5">Fresh</div>
                                <div class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Ingredients</div>
                            </div>
                            <div class="text-center">
                                <div class="text-orange-600 font-black text-lg mb-0.5">Fast</div>
                                <div class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Delivery</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endwhile; ?>
</div>

<?php
get_footer();
?>